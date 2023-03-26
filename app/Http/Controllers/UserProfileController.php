<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use App\Models\Category;
use App\Models\User;
use App\Models\UserCategories;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function index()
    {
        $users = User::with('membership')->has('membership')->get();
        return view('pages.user.user-management', ["users" => $users]);
    }


    public function create(Request $request)
    {
    }


    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:150', 'min:2', Rule::unique('users')],
            'email' => ['required', 'email', 'max:150',  Rule::unique('users')->ignore(auth()->user()->id)]
        ]);

        $username = str_replace(" ", "_", strtolower($request->name));
        $request->merge(["username" => $username]);

        User::create($request->all())->save();

        return back()->with('succes', 'User created!');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $access_levels = AccessLevel::all();
        $categories = Category::all();
        return view('pages.user.user-profile', [
            "user" => $user,
            "categories" => $categories,
            "levels" => $access_levels
        ]);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return back()->with('succes', 'User deleted!');
    }

    public function moderation()
    {
        $users = User::where("access_level", "!=", "1")->get();
        return view('pages.user.moderation', ["users" => $users]);
    }

    public function update(Request $request, $id)
    {
        /* $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]); */

        $user = User::findOrFail($id);
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar_path = $request->file('avatar')->store('uploads/images/users', 'public');
            $user->avatar = '/storage/' . $avatar_path;
        } else {
            $user->avatar = $request->input('avatar_path');
        }
        $user->fill($request->input());
        $user->save();

        return redirect(route('users.edit', $id))->with('succes', 'Profile succesfully updated');
    }

    public function setUserStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status) {
            $user->status = 0; // Unbanned
        } else {
            $user->status = 1; // Banned
            // Revoke all tokens...
            $user->tokens()->delete();
        }
        $user->save();
        return back();
    }

    public function markNotificationAsRead()
    {
        return Auth::user()->unreadNotifications->markAsRead();
    }
}
