<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MidtransController extends Controller
{
    public function __construct()
    {
        $this->baseURL = config('midtrans.baseURL');
        $this->serverKey = config('midtrans.serverKey');
        $this->clientKey = config('midtrans.clientKey');
    }

    public function getcardToken(Request $request)
    {
        $response = Http::withBasicAuth($this->serverKey, "")

        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])

        ->get($this->baseURL . '/token', [
            'client_key' => $this->clientKey,
            'card_number' => $request->card_number,
            'card_exp_month' => $request->card_exp_month,
            'card_exp_year' => $request->card_exp_year,
            'card_cvv' => $request->card_cvv,
        ]);

        return json_decode($response->body(), true);
    }

    public function getStatus($orderID)
    {
        $response = Http::withBasicAuth($this->serverKey, "")

        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])

        ->get($this->baseURL . '/' . $orderID . '/status');

        return json_decode($response->body(), true);
    }

    public function chargeCreditCard(Request $request)
    {
        $response = Http::withBasicAuth($this->serverKey, "")

        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])

        ->post($this->baseURL . '/charge', [
            'payment_type' => "credit_card",
            'transaction_details' => [
                'order_id' => "order-101a-" . Str::random(6),
                'gross_amount' => $request->gross_amount,
            ],
            'credit_card' => [
                'token_id' => $request->token_id,
            ],
        ]);

        return json_decode($response->body(), true);
    }

    public function chargeGopay(Request $request)
    {
        $response = Http::withBasicAuth($this->serverKey, "")

        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])

        ->post($this->baseURL . '/charge', [
            'payment_type' => "gopay",
            'transaction_details' => [
                'order_id' => "order-101a-" . Str::random(6),
                'gross_amount' => $request->gross_amount,
            ],
            'gopay' => [
                'enable_callback' => true,
                'callback_url' => "someapps://callback"
            ],
        ]);

        return json_decode($response->body(), true);
    }

    public function cancelTransaction($orderID)
    {
        $response = Http::withBasicAuth($this->serverKey, "")

        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])

        ->post($this->baseURL . '/' . $orderID . '/cancel');

        return json_decode($response->body(), true);
    }
}
