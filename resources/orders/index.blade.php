@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Account</p>
                    <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        View your recent orders, status and details.
                    </p>
                </div>

                <a href="{{ route('catalog.index') }}" class="text-sm text-gray-500 hover:text-gray-800">
                    ← Continue shopping
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 px-4 py-2 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($orders->isEmpty())
                <div class="rounded-2xl bg-white p-6 text-sm text-gray-600 shadow">
                    You have no orders yet.
                    <a href="{{ route('catalog.index') }}" class="text-indigo-600 hover:text-indigo-700">
                        Start shopping →
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <a href="{{ route('user.orders.show', $order) }}"
                            class="block rounded-2xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-400 hover:shadow-md">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="font-mono text-gray-900">
                                            #{{ $order->order_number }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            · {{ $order->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $order->items_count }} item{{ $order->items_count > 1 ? 's' : '' }}
                                        • Total:
                                        <span class="font-semibold text-gray-900">
                                            RM {{ number_format($order->total, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    {{-- 订单状态 badge --}}
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                                            'paid' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                            'processing' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                            'completed' => 'bg-green-50 text-green-700 ring-green-200',
                                            'cancelled' => 'bg-red-50 text-red-700 ring-red-200',
                                        ];

                                        $statusLabel = ucfirst($order->status);
                                        $statusClass =
                                            $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';

                                        $paymentColors = [
                                            'unpaid' => 'bg-gray-50 text-gray-700 ring-gray-200',
                                            'paid' => 'bg-green-50 text-green-700 ring-green-200',
                                            'failed' => 'bg-red-50 text-red-700 ring-red-200',
                                            'refunded' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                                        ];
                                        $paymentClass =
                                            $paymentColors[$order->payment_status] ??
                                            'bg-gray-50 text-gray-700 ring-gray-200';
                                    @endphp

                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $paymentClass }}">
                                        Payment: {{ ucfirst($order->payment_status) }}
                                    </span>

                                    <span class="text-xs font-medium text-indigo-600">
                                        View details →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
