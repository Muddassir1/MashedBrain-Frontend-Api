<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMemberships;
use App\Notifications\NewUserRegistration;
use App\Notifications\TransactionNotification;
use Illuminate\Database\QueryException;
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
            'password' => 'required|min:5|max:255|confirmed',
            'phone' => 'required|unique:users,phone'
        ]);

        $username = str_replace(" ", "_", strtolower($request->name));
        $request->merge(compact("username"));

        //Send message
        $twilio = new Client($this->sid, $this->token);

        try {
            $twilio->verify->v2->services($this->vsid)
                ->verifications
                ->create($request->phone, "sms");
            return response()->json($request->all());
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

            if ($verification_check->status == "approved") {
                $request->merge(["phone_verified" => 1]);
                $user = User::create($request->all());
                Notification::send(User::where('access_level', 3)->get(), new NewUserRegistration($user));
            }
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

    public function createUser(Request $request)
    {
        try {
            $request->merge(["avatar" => "/img/defaults/avatar/user.png"]);
            $user = User::create($request->all());
            Notification::send(User::where('access_level', 3)->get(), new NewUserRegistration($user));
            $data = $request->all();
            $transaction = Transaction::create([
                'user_id'               => $user->id,
                'transaction_id'        => $data['tran_id'],
                'bank_transaction_id'   => $data['bank_tran_id'],
                'val_id'                => $data['val_id'],
                'amount'                => $data['amount'],
                'membership_id'         => $data['membership_id'],
                'payment_method'        => $data['card_type'],
                'status'                => 'VALID'
            ]);

            UserMemberships::updateOrCreate(
                ['user_id' => $user->id],
                ["membership_id" => $data['membership_id']]
            );

            Notification::send(User::where('access_level', 3)->get(), new TransactionNotification($transaction));
            
            return response()->json($user);
        } catch (QueryException $e) {
            return response()->json(["msg" => $e->getMessage()], 400);
        }
    }
}
