<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;

class PaypalController extends Controller
{
    public function paypal(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('form');
        }
        
        $request->validate([
            'product_name' => 'required|string|min:3',
            'quantity' => 'required|int|min:1',
            'price' => 'required|int|min:1',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.transaction'),
                "cancel_url" => route('failed')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => env('PAYPAL_CURRENCY'),
                        "value" => $request->price
                    ]
                ]
            ]
        ]);
        //dd($response);
        if(isset($response['id']) && $response['id'] != null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {
                    session()->put('product_name', $request->product_name);
                    session()->put('quantity', $request->quantity);
                    return redirect()->away($link['href']);
                }
            }
            return $this->failed();
        } else {
            return $this->failed();
        }
    }
    public function transaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            return $this->saved($response); // Insert data into database
            session()->forget('product_name'); session()->forget('quantity');
        } else {
            return $this->failed();
        }
    }
    public function failed()
    {
        return redirect()->route('failed', ['message' => 'Payment is cancelled.']);
    }
    public function saved($response)
    {
        $payment = new Payment;
        $payment->payment_id = $response['id'];
        $payment->product_name = session()->get('product_name');
        $payment->quantity = session()->get('quantity');
        $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount'];
        $payment->amount = $amount['value'];
        $payment->currency = $amount['currency_code'];
        $payment->payer_name = $response['payer']['name']['given_name'];
        $payment->payer_email = $response['payer']['email_address'];
        $payment->payment_status = $response['status'];
        $payment->payment_method = "PayPal";
        $payment->save();
        return view('success', ['message' => 'Payment is successful.', 'payment' => $payment]);
    }
}