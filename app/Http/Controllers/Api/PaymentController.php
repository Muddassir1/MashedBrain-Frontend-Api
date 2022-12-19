<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function __construct()
    {
        $mode = getenv("PAYMENT_MODE");
        if ($mode == "sandbox") {
            $this->validation_url = getenv("VALIDATION_API_SANDBOX");
        } else {
            $this->validation_url = getenv("VALIDATION_API_LIVE");
        }

        $this->storeId = getenv("STORE_ID");
        $this->storePass = getenv("STORE_PASSWORD");
    }

    public function ipn(Request $request)
    {
        Log::debug("request recieved");
        extract($request->all());
        if ($status == 'VALID') {
            $response = Http::post($this->validation_url, [
                'val_id' => $val_id,
                'store_id' => $this->storeId,
                'store_pass' => $this->storePass
            ]);
            dd($response);
        }
    }

    public function success(Request $request)
    {
        Log::debug("Success route called");
        extract($request->all());
        if ($status == 'VALID' || $status == 'VALIDATED') {
            $response = Http::get($this->validation_url, [
                'val_id' => $val_id,
                'store_id' => $this->storeId,
                'store_passwd' => $this->storePass
            ]);
            $data = json_decode($response->body());
            if ($data->status == 'VALID' || $data->status == 'VALIDATED') {

                Transaction::create([
                    'user_id'               => $data->value_b,
                    'transaction_id'        => $data->tran_id,
                    'bank_transaction_id'   => $data->bank_tran_id,
                    'val_id'                => $data->val_id,
                    'amount'                => $data->amount,
                    'membership_id'         => $data->value_a,
                    'payment_method'        => $data->card_type,
                    'status'                => $data->status
                ]);

                return response()->json([
                    'message' => 'Transaction successfully created'
                ]);
            }
            return response()->json([
                'message' => "Transaction couldn't be completed. Please try again"
            ], 400);
        }
    }

    public function verify(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $transaction = Transaction::where('transaction_id', $transaction_id)->firstOrFail();

        /* if ($transaction->user_id == NULL) {
            $transaction->user_id = $request->user()->id;
            $transaction->save();
        } */

        if ($transaction->status == 'VALID' || $transaction->status == 'VALIDATED') {
            return response()->json([
                'valid' => true
            ]);
        } else
            return response()->json([
                'valid' => false
            ], 422);
    }

    public function fail()
    {
        return response()->json([
            'message' => "The payment was cancelled or failed"
        ], 400);
    }
}
