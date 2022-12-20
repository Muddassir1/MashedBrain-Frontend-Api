<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCategories;
use App\Models\UserMemberships;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;

class UserController extends Controller
{
    use Notifiable;

    public function index(Request $request)
    {
        $user = User::with(['membership','categories'])->find($request->user()->id);
        return $user;
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatar_path = $request->file('avatar')->store('uploads/images/users', 'public');
            $user->avatar = '/storage/' . $avatar_path;
        }
        $user->save();

        return response()->json([
            "message" => "Profile updated successfully"
        ]);
    }

    public function resetPassword(Request $request)
    {

        $user = $request->user();

        $request->validate([
            'old_pass' => 'required',
            'password' => 'required|min:5|max:255|confirmed|different:old_pass'
        ]);

        if (Hash::check($request->old_pass, $user->password)) {
            $user->fill([
                'password' => $request->password
            ])->save();

            return response()->json(["message" => "Password changed successfully!"]);
        }
        return response()->json(["message" => "Incorrect password"], 401);
    }

    public function settings(Request $request)
    {
        return $request->user()->settings;
    }

    public function updateSettings(Request $request)
    {
        $uid = $request->user()->id;
        $settings = UserSetting::updateOrCreate(
            ['user_id' => $uid],
            $request->all()
        );
        return response()->json($settings);
    }

    public function updateCategories(Request $request)
    {
        $uid = $request->user()->id;
        $categories = implode(",", $request->input('category'));
        UserCategories::updateOrCreate(
            ['user_id' => $uid],
            ['categories' => $categories]
        );
        return response()->json([
            "message" => "Record saved successfully"
        ]);
    }

    public function updateMembership(Request $request)
    {
        $uid = $request->user()->id;
        UserMemberships::updateOrCreate(
            ['user_id' => $uid],
            $request->all()
        );
        return response()->json([
            "message" => "Record saved successfully"
        ]);
    }
}
