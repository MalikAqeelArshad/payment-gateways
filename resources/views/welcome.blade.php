@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <form action="{{ route('paypal') }}" method="post" style="margin: auto">
        @csrf
        <p><b>Product:</b> <input type="text" name="product_name" value="Title of the product"></p>
        <p><b>Price:</b> <b style="position:relative;left:1rem;">$</b><input type="number" name="price" value="5"></p>
        <input type="hidden" name="quantity" value="1">
        <button type="submit" class="btn">Pay with PayPal</button>
        @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </form>
</div>
@endsection