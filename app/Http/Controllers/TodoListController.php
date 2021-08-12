<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Todolist;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
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

    public function create()
    {
        $this->validate(request(), [
            'account_name' => ['required', 'string', 'max:255', 'unique:accounts,account_name', 'regex:/^[A-Za-z][\sa-zA-Z0-9_-]+$/'],
            'account_type' => ['required', 'string', 'max:255'],
        ]);

        return redirect('/')->with('status', 'Successfully Created Bank Todolist!');
    }

    public function generateUniqueId()
    {
        do {
            $id = random_int(1000000, 9999999) + 10000000000;
        } while (Todolist::where("account_id", $id)->first());

        return $id;
    }

    public function update()
    {
        $pin = Auth::user()->pin_number;

        $this->validate(request(), [
            'balance' => ['required', 'numeric'],
            'pin_number_deposit' => ['required', function ($attribute, $value, $fail) use ($pin) {
                if ($value !== $pin) {
                    return $fail(__('The pin number is incorrect.'));
                }
            }],
        ]);
        $account = Todolist::where('id', request()->account_id)->firstOrFail();
        $user = User::where('id', $account->user_id)->firstOrFail();

        $account->balance += request()->balance;
        $account->save();
        $user->push();


        return redirect('/')->with('status', 'Successfully Deposited!');
    }
}
