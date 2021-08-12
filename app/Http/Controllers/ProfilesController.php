<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
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

    public function show()
    {
        $user = Auth::user();
        return view('profiles.show', compact('user'));
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'pin_number' => ['required', 'string', 'min:6', 'max:6'],
            'phone_number' => ['string', 'max:50'],
            'dob' => ['date', 'nullable', 'max:50'],
            'address' => ['string', 'nullable', 'max:255']
        ]);

        $user->name = request()->name;
        $user->pin_number = request()->pin_number;
        $user->profile->phone_number = request()->phone_number;
        $user->profile->dob = request()->dob;
        $user->profile->address = request()->address;
        $user->save();
        $user->push();

        return redirect('profiles');
    }
}
