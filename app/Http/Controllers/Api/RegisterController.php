<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Throwable;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    protected $sid;
    protected $token;
    protected $vsid;

    public function __construct()
    {
        $this->sid = getenv("TWILIO_ACCOUNT_SID");
        $this->token = getenv("TWILIO_AUTH_TOKEN");
        $this->vsid = getenv("TWILIO_VERIFICATION_SID");
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255|confirmed'
        ]);

        $username = str_replace(" ", "_", strtolower($request->name));
        $request->merge(compact("username"));

        //Send message
        $twilio = new Client($this->sid, $this->token);

        try {
            $twilio->verify->v2->services($this->vsid)
                ->verifications
                ->create($request->phone, "sms");
            $user = User::create($request->all());

            Notification::send(User::where('access_level', 3)->get(), new NewUserRegistration($user));

            return response()->json($user);
        } catch (Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    public function verify(Request $request)
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
            User::where('phone', $phone)->update(['phone_verified' => 1]);
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
}
