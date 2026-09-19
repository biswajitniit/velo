@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h2 class="text-danger">Payment Cancelled</h2>
        <p>Your payment was cancelled.</p>

        <a href="{{ route('create-account') }}" class="btn btn-primary">
            Try Again
        </a>
    </div>
@endsection
