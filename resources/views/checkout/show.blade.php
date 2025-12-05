@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Name</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}"
                            class="border rounded w-full px-2 py-1">
                        @error('customer_name')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $user->email) }}"
                            class="border rounded w-full px-2 py-1">
                        @error('customer_email')
                            <div class="text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Phone</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                            class="border rounded w-full px-2 py-1">
                    </div>

                    <div class="mt-4 font-semibold">Shipping Address</div>

                    <div>
                        <label class="block text-sm mb-1">Address Line 1</label>
                        <input type="text" name="shipping_address_line1" value="{{ old('shipping_address_line1') }}"
                            class="border rounded w-full px-2 py-1">
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Address Line 2</label>
                        <input type="text" name="shipping_address_line2" value="{{ old('shipping_address_line2') }}"
                            class="border rounded w-full px-2 py-1">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm mb-1">City</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}"
                                class="border rounded w-full px-2 py-1">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">State</label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state') }}"
                                class="border rounded w-full px-2 py-1">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm mb-1">Postcode</label>
                            <input type="text" name="shipping_postcode" value="{{ old('shipping_postcode') }}"
                                class="border rounded w-full px-2 py-1">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Country</label>
                            <input type="text" name="shipping_country" value="{{ old('shipping_country', 'Malaysia') }}"
                                class="border rounded w-full px-2 py-1">
                        </div>
                    </div>

                    <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Place Order
                    </button>
                </form>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-semibold mb-2">Order Summary</h2>
                @foreach ($cart['items'] as $item)
                    <div class="flex justify-between text-sm mb-1">
                        <div>
                            {{ $item['name'] }}
                            @if ($item['variant'])
                                <span class="text-xs text-gray-500">({{ $item['variant'] }})</span>
                            @endif
                            × {{ $item['quantity'] }}
                        </div>
                        <div>
                            RM {{ number_format($item['line_total'], 2) }}
                        </div>
                    </div>
                @endforeach
                <hr class="my-2">
                <div class="flex justify-between font-semibold">
                    <span>Subtotal</span>
                    <span>RM {{ number_format($cart['subtotal'], 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Shipping</span>
                    <span>RM 0.00</span>
                </div>
                <div class="flex justify-between font-bold mt-2">
                    <span>Total</span>
                    <span>RM {{ number_format($cart['subtotal'], 2) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
