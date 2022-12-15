<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMemberships;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
