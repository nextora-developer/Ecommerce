@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
            <h1 class="mb-4 text-2xl font-bold text-gray-900">Shopping cart</h1>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 px-4 py-2 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-50 px-4 py-2 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if (empty($cart['items']))
                <div class="rounded-2xl bg-white p-6 text-sm text-gray-600 shadow">
                    Your cart is empty. <a href="{{ route('catalog.index') }}"
                        class="text-indigo-600 hover:text-indigo-700">Start shopping →</a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="md:col-span-2 rounded-2xl bg-white p-4 shadow">
                        <div class="divide-y">
                            @foreach ($cart['items'] as $key => $item)
                                <div class="flex items-center justify-between py-3">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $item['name'] }}
                                        </div>
                                        @if ($item['variant'])
                                            <div class="text-xs text-gray-500">Variant: {{ $item['variant'] }}</div>
                                        @endif
                                        <div class="mt-1 text-xs text-gray-500">
                                            Unit price: RM {{ number_format($item['price'], 2) }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('cart.update') }}" method="POST"
                                            class="flex items-center gap-1">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                min="1"
                                                class="w-16 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button class="text-xs font-medium text-indigo-600 hover:text-indigo-700">
                                                Update
                                            </button>
                                        </form>

                                        <div class="text-sm font-semibold text-gray-900">
                                            RM {{ number_format($item['line_total'], 2) }}
                                        </div>

                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <button class="text-xs font-medium text-red-500 hover:text-red-600">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-4 shadow">
                        <h2 class="mb-3 text-sm font-semibold text-gray-900">Order summary</h2>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Subtotal</dt>
                                <dd class="font-medium text-gray-900">RM {{ number_format($cart['subtotal'], 2) }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Shipping</dt>
                                <dd class="text-gray-500">RM 0.00</dd>
                            </div>
                            <div class="flex justify-between border-t pt-2 text-sm font-semibold">
                                <dt class="text-gray-900">Total</dt>
                                <dd class="text-gray-900">RM {{ number_format($cart['subtotal'], 2) }}</dd>
                            </div>
                        </dl>

                        <a href="{{ route('checkout.show') }}"
                            class="mt-4 inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                            Checkout
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
