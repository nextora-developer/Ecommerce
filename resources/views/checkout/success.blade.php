@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-12 text-center">
        <h1 class="text-2xl font-bold mb-4">Thank you!</h1>
        <p class="mb-2">Your order has been placed.</p>
        <p class="mb-4">Order Number: <span class="font-mono">{{ $order->order_number }}</span></p>

        <a href="{{ route('catalog.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Back to Shop
        </a>
    </div>
@endsection
