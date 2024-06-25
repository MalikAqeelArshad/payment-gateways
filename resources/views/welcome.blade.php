@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <div style="margin:auto;">
        <div class="card">
            <h2 style="color:orangered;margin:0;">Stripe</h2>
            <p>Pay with Stripe payment gateway</p>
            <a href="{{ route('stripe.index') }}" class="btn">Pay with Stripe</a>
        </div>
        <hr>
        <div class="card">
            <h2 style="color:orangered;margin:0;">PayPal</h2>
            <p>Pay with PayPal payment gateway</p>
            <a href="{{ route('paypal.index') }}" class="btn">Pay with PayPal</a>
        </div>
    </div>
</div>
@endsection