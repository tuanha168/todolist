<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TemporaryTransaction;
use Illuminate\Support\Facades\Auth;
use Seshac\Otp\Otp;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($account_id, $limit = 999)
    {
        $transaction = $this->getAllTransaction($account_id, $limit);
        $account = Account::where('id', $account_id)->first();
        return view('transaction.show', compact('account', 'transaction'));
    }

    public static function getAllTransaction($account_id, $limit)
    {
        $senderId = $receiverId = $account_id;
        return Transaction::query()
            ->where(function ($q) use ($senderId, $receiverId) {
                $q->whereHas('sender', function ($qq) use ($senderId) {
                    $qq->where('id', $senderId);
                });
                $q->orWhereHas('reciver', function ($qq) use ($receiverId) {
                    $qq->where('id', $receiverId);
                });
            })
            ->orderBy('created_at', 'DESC')
            ->take($limit)
            ->get();
    }

    public function create()
    {
        $pin = Auth::user()->pin_number;
        $sender = Account::where('id', request()->account_id)->first();
        $this->validate(request(), [
            'reciver_account_id' => ['required', 'string', function ($attribute, $value, $fail) use ($sender) {
                $found = Account::where('account_id', $value)->first();
                if (!$found) {
                    return $fail(__('Account not found!'));
                } else if ($found->id === $sender->id) {
                    return $fail(__('Can`t not transfers to same Account!'));
                }
            }],
            'amount' => ['required', 'numeric', function ($attribute, $value, $fail) use ($sender) {
                if ((int)$value > $sender->balance) {
                    return $fail(__('Balance not enough, please charge!'));
                }
            }],
            'pin_number_tranfers' => ['required', function ($attribute, $value, $fail) use ($pin) {
                if ($value !== $pin) {
                    return $fail(__('The pin number is incorrect.'));
                }
            }]
        ]);
        $otp =  Otp::generate(Auth::id());
        if ($otp->status === false)
            return redirect('/')->with('status_error', $otp->message);
        $reciver = Account::where('account_id', request()->reciver_account_id)->first();
        TemporaryTransaction::create([
            'otp' => (int)$otp->token,
            'sender_id' => $sender->id,
            'reciver_id' => $reciver->id,
            'amount' => (int)request()->amount,
            'message' => request()->message,
        ]);
        $user = User::where('id', $sender->user_id)->first();
        $user->otp = $otp->token;
        $user->save();

        return redirect('/')->with('otp', 'Your OTP is ' . $otp->token);
    }

    public function confirm()
    {
        $this->validate(request(), [
            'otp_number' => ['required', 'string', function ($attribute, $value, $fail) {
                $verify = Otp::validate(Auth::id(), $value);
                if ($verify->status === false) {
                    return $fail($verify->message);
                }
            }]
        ]);
        $transaction = TemporaryTransaction::where('otp', request()->otp_number)->first();
        $sender = Account::where('id', $transaction->sender_id)->first();
        $user = User::where('id', $sender->user_id)->first();
        $reciver = Account::where('id', $transaction->reciver_id)->first();
        $user->otp = null;
        $sender->balance -= (int)$transaction->amount;
        $reciver->balance += (int)$transaction->amount;
        Transaction::create([
            'sender_id' => $sender->id,
            'reciver_id' => $reciver->id,
            'sender_account_id' => $sender->account_id,
            'reciver_account_id' => $reciver->account_id,
            'amount' => (int)$transaction->amount,
            'message' => $transaction->message,
            'sender_balance' => $sender->balance,
            'reciver_balance' => $reciver->balance
        ]);
        $transaction->delete();
        $sender->save();
        $reciver->save();
        $user->save();
        $user->push();

        return redirect('/')->with('status', 'Successfully Transfers ' . $transaction->amount . '$ to ' . $reciver->account_id);
    }
}
