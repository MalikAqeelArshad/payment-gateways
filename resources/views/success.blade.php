@extends('layouts.app')

@section('title', 'Transaction Successful')

@section('content')
<div class="container">
    <div style="max-width:300px;margin:auto">
    	<h1>Success</h1>
    	<p>{{ $message }}</p>
    	<pre>{{ json_encode($payment, JSON_PRETTY_PRINT) }}</pre>
    	<a href="{{ url('/') }}" class="btn">Go back to Home</a>
    </div>
</div>
@endsection