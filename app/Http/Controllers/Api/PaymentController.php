<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            if($data->status == 'VALID' || $data->status == 'VALIDATED'){
                
            }
        }
    }

    public function verify(Request $request)
    {
        if ($status == 'VALID') {
            $response = Http::get($this->validation_url, [
                'val_id' => $val_id,
                'store_id' => $this->storeId,
                'store_passwd' => $this->storePass
            ]);
            dd($response->body());
        }
    }

    public function fail()
    {
    }
}
