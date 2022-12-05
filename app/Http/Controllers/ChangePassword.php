<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Controller
{

    protected $user;

    public function __construct()
    {
        Auth::logout();

        $id = intval(request()->id);
        $this->user = User::find($id);
    }

    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required'],
            'c_password' => ['required'],
            'password' => ['required', 'min:5'],
            'confirm-password' => ['same:password']
        ]);

        $existingUser = User::where('email', $attributes['email'])->first();
        $currentPass = $attributes['c_password'];

        if ($existingUser && Hash::check($currentPass, $existingUser->password)) {
            $existingUser->update([
                'password' => $attributes['password']
            ]);
            return back()->with('succes','Password updated!');
        } else {
            return back()->with('error', 'Your email/password does not match');
        }
    }
}
