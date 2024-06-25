<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class StripeController extends Controller
{
    public function stripe(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|min:3',
            'quantity' => 'required|int|min:1',
            'price' => 'required|int|min:1',
        ]);

        $stripe = new \Stripe\StripeClient(env('STRIPE_TEST_SK'));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => env('STRIPE_CURRENCY'),
                        'product_data' => [
                            'name' => $request->product_name,
                        ],
                        'unit_amount' => $request->price * 100,
                    ],
                    'quantity' => $request->quantity,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.transaction').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('failed'),
        ]);
        //dd($response);
        if(isset($response->id) && $response->id != ''){
            session()->put('product_name', $request->product_name);
            session()->put('quantity', $request->quantity);
            session()->put('price', $request->price);
            return redirect($response->url);
        } else {
            return $this->failed();
        }
    }

    public function transaction(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(env('STRIPE_TEST_SK'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            return $this->saved($response); // Insert data into database

            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');

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
        $payment->payment_id = $response->id;
        $payment->product_name = session()->get('product_name');
        $payment->quantity = session()->get('quantity');
        $payment->amount = session()->get('price');
        $payment->currency = $response->currency;
        $payment->payer_name = $response->customer_details->name;
        $payment->payer_email = $response->customer_details->email;
        $payment->payment_status = $response->status;
        $payment->payment_method = "Stripe";
        $payment->save();
        return view('success', ['message' => 'Payment is successful.', 'payment' => $payment]);
    }
}