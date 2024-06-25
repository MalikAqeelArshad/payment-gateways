@extends('layouts.app')

@section('title', 'Transaction Failed')

@section('content')
<div class="container">
    <div style="max-width:300px;margin:auto">
		<h1 style="margin:0">Oops</h1>
		<p style="margin:0"><small>Something went wrong</small></p>
		<p>{{ $message ?? 'Payment is cancelled.' }}</p>
    	<a href="{{ url('/') }}" class="btn">Go back to Home</a>
	</div>
</div>
@endsection