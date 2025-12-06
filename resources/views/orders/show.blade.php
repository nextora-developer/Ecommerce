@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Order</p>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Order #{{ $order->order_number }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Placed on {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>

                <a href="{{ route('user.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-800">
                    ← Back to My Orders
                </a>
            </div>

            @php
                $statusColors = [
                    'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                    'paid' => 'bg-blue-50 text-blue-700 ring-blue-200',
                    'processing' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                    'completed' => 'bg-green-50 text-green-700 ring-green-200',
                    'cancelled' => 'bg-red-50 text-red-700 ring-red-200',
                ];
                $statusLabel = ucfirst($order->status);
                $statusClass = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';

                $paymentColors = [
                    'unpaid' => 'bg-gray-50 text-gray-700 ring-gray-200',
                    'paid' => 'bg-green-50 text-green-700 ring-green-200',
                    'failed' => 'bg-red-50 text-red-700 ring-red-200',
                    'refunded' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                ];
                $paymentClass = $paymentColors[$order->payment_status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';
            @endphp

            <div class="grid gap-6 md:grid-cols-3">
                <!-- 左：订单信息 + 收件信息 -->
                <div class="space-y-4 md:col-span-1">
                    <div class="rounded-2xl bg-white p-4 shadow">
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">Status</h2>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 font-medium ring-1 {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 font-medium ring-1 {{ $paymentClass }}">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        <dl class="mt-4 space-y-1 text-xs text-gray-600">
                            <div class="flex justify-between">
                                <dt>Order date</dt>
                                <dd>{{ $order->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            @if ($order->payment_method)
                                <div class="flex justify-between">
                                    <dt>Payment method</dt>
                                    <dd>{{ ucfirst($order->payment_method) }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="rounded-2xl bg-white p-4 shadow">
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">Shipping address</h2>
                        <div class="text-xs text-gray-600">
                            <div class="font-semibold text-gray-900">{{ $order->customer_name }}</div>
                            <div>{{ $order->customer_email }}</div>
                            @if ($order->customer_phone)
                                <div>{{ $order->customer_phone }}</div>
                            @endif
                            <div class="mt-2">
                                @if ($order->shipping_address_line1)
                                    <div>{{ $order->shipping_address_line1 }}</div>
                                @endif
                                @if ($order->shipping_address_line2)
                                    <div>{{ $order->shipping_address_line2 }}</div>
                                @endif
                                @if ($order->shipping_city || $order->shipping_state || $order->shipping_postcode)
                                    <div>
                                        {{ $order->shipping_postcode }}
                                        {{ $order->shipping_city }}
                                        {{ $order->shipping_state }}
                                    </div>
                                @endif
                                @if ($order->shipping_country)
                                    <div>{{ $order->shipping_country }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white p-4 shadow">
                        <h2 class="mb-2 text-sm font-semibold text-gray-900">Amount</h2>
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <dt>Subtotal</dt>
                                <dd>RM {{ number_format($order->subtotal, 2) }}</dd>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <dt>Shipping</dt>
                                <dd>RM {{ number_format($order->shipping_fee, 2) }}</dd>
                            </div>
                            @if ($order->discount_amount > 0)
                                <div class="flex justify-between text-gray-600">
                                    <dt>Discount</dt>
                                    <dd>- RM {{ number_format($order->discount_amount, 2) }}</dd>
                                </div>
                            @endif
                            <div class="flex justify-between border-t pt-2 text-sm font-semibold text-gray-900">
                                <dt>Total</dt>
                                <dd>RM {{ number_format($order->total, 2) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- 右：商品列表 -->
                <div class="md:col-span-2 rounded-2xl bg-white p-4 shadow">
                    <h2 class="mb-3 text-sm font-semibold text-gray-900">Items</h2>

                    <div class="divide-y">
                        @foreach ($order->items as $item)
                            <div class="flex flex-col justify-between gap-3 py-3 sm:flex-row sm:items-center">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $item->product_name }}
                                    </div>
                                    @if ($item->variant_name)
                                        <div class="text-xs text-gray-500">
                                            Variant: {{ $item->variant_name }}
                                        </div>
                                    @endif
                                    <div class="mt-1 text-xs text-gray-500">
                                        Qty: {{ $item->quantity }}
                                        • Unit price: RM {{ number_format($item->unit_price, 2) }}
                                    </div>
                                </div>

                                <div class="text-sm font-semibold text-gray-900">
                                    RM {{ number_format($item->line_total, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($order->notes)
                        <div class="mt-4 rounded-lg bg-gray-50 p-3 text-xs text-gray-600">
                            <div class="mb-1 font-semibold text-gray-800">Notes</div>
                            {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
