@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>

        @if (session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 text-red-700">{{ session('error') }}</div>
        @endif

        @if (empty($cart['items']))
            <p>Your cart is empty.</p>
        @else
            <table class="w-full text-sm mb-4">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart['items'] as $key => $item)
                        <tr class="border-b">
                            <td class="py-2">
                                <div class="font-semibold">{{ $item['name'] }}</div>
                                @if ($item['variant'])
                                    <div class="text-xs text-gray-500">{{ $item['variant'] }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('cart.update') }}" method="POST"
                                    class="inline-flex items-center gap-1">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        class="w-16 border rounded px-1 py-0.5 text-center text-sm">
                                    <button class="text-xs text-blue-600 ml-1">Update</button>
                                </form>
                            </td>
                            <td class="text-center">
                                RM {{ number_format($item['price'], 2) }}
                            </td>
                            <td class="text-center">
                                RM {{ number_format($item['line_total'], 2) }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button class="text-xs text-red-600">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-between items-center mb-4">
                <div class="font-semibold">
                    Subtotal: RM {{ number_format($cart['subtotal'], 2) }}
                </div>

                <a href="{{ route('checkout.show') }}"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Checkout
                </a>
            </div>
        @endif
    </div>
@endsection
