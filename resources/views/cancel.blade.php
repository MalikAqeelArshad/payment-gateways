@extends('layouts.app')

@section('title', 'Transaction Failed')

@section('content')
<div class="container">
    <div style="max-width:300px;margin:auto">
		<h1>Oops</h1>
		<p>{{ $message }}</p>
    	<a href="{{ url('/') }}" class="btn">Go back to Home</a>
	</div>
</div>
@endsection