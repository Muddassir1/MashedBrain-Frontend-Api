<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCategories;
use App\Models\UserMemberships;
use App\Models\UserNotificationTokens;
use App\Models\UserSetting;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserController extends Controller
{
    use Notifiable;


    public function __construct()
    {
        $this->sid = getenv("TWILIO_ACCOUNT_SID");
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->vsid = getenv("TWILIO_VERIFICATION_SID");
    }

    public function index(Request $request)
    {
        $user = User::with(['membership.details', 'categories'])->find($request->user()->id);
        return $user;
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->about = $request->about;

        //dd($request->allFiles());
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

    public function resetPasswordRequestVerify(Request $request)
    {
        $phone = $request->phone;
        $code = $request->code;

        $twilio = new Client($this->sid, $this->token);
        try {
            $verification_check = $twilio->verify->v2->services($this->vsid)
                ->verificationChecks
                ->create(
                    [
                        "to" => $phone,
                        "code" => $code
                    ]
                );
        } catch (Throwable $th) {
            return response()->json(
                [
                    "message" => "Record not found",
                    "status" => "failed"
                ],
                $th->getStatusCode()
            );
        }
        return response()->json(["status" => $verification_check->status]);
    }

    public function resetPasswordRequest(Request $request)
    {
        $phone = $request->validate([
            'phone' => ['required']
        ]);

        $user = User::where('phone', $phone)->firstOrFail();

        if ($user) {
            //Send message
            $twilio = new Client($this->sid, $this->token);

            try {
                $twilio->verify->v2->services($this->vsid)
                    ->verifications
                    ->create($request->phone, "sms");
                Auth::loginUsingId($user->id);
                return response()->json([
                    "message" => "Code sent to the provided number",
                    "token" => $user->createToken($user->name)->plainTextToken
                ]);
            } catch (Throwable $th) {
                return response()->json(["message" => $th->getMessage()], 500);
            }
        }
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

    public function saveNotificationToken(Request $request)
    {
        UserNotificationTokens::updateOrCreate(
            ['user_id' => $request->user()->id],
            ['token' => $request->token]
        );
    }
}
