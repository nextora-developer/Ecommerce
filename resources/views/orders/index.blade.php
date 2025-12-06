@extends('account.layout')

@section('account-breadcrumb', 'Account / Orders')

@section('account-content')
    @php
        $tabs = [
            'all' => 'All',
            'unpaid' => 'Unpaid',
            'paid' => 'Paid',
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    @endphp

    <div class="space-y-6">

        {{-- 标题 --}}
        {{-- <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-400">Account</p>
                <h1 class="text-2xl font-semibold text-gray-900">My Orders</h1>
                <p class="mt-1 text-sm text-gray-600">
                    View your recent orders, status and details.
                </p>
            </div>

            <a href="{{ route('catalog.index') }}" class="text-xs font-medium text-gray-500 hover:text-gray-800">
                ← Continue shopping
            </a>
        </div> --}}

        {{-- Tabs + 搜索 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 pt-4 pb-5 shadow-sm">
            {{-- Tabs --}}
            <div class="border-b border-gray-100">
                <nav class="-mb-px flex flex-wrap gap-4 text-sm">
                    @foreach ($tabs as $key => $label)
                        @php
                            $active = $activeStatus === $key;
                        @endphp
                        <a href="{{ route('user.orders.index', ['status' => $key] + ($search ? ['q' => $search] : [])) }}"
                            class="pb-3 border-b-2 {{ $active ? 'border-rose-500 text-gray-900 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-800 hover:border-gray-200' }}">
                            {{ $label }}
                            @if (($counts[$key] ?? 0) > 0)
                                <span class="ml-1 text-xs text-gray-400">({{ $counts[$key] }})</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- 搜索栏 --}}
            <form method="GET" action="{{ route('user.orders.index') }}" class="mt-4 flex gap-2">
                {{-- 保留当前 tab --}}
                <input type="hidden" name="status" value="{{ $activeStatus }}">

                <div class="flex-1">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Order number"
                        class="w-full rounded-full border border-gray-200 px-4 py-2.5 text-sm
                              focus:border-rose-400 focus:ring-rose-400">
                </div>

                <button type="submit"
                    class="rounded-full bg-rose-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-rose-600">
                    Search
                </button>
            </form>
        </div>

        {{-- 列表 / 空状态 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm min-h-[320px]">
            @if ($orders->isEmpty())
                {{-- 空状态 --}}
                <div class="flex h-64 flex-col items-center justify-center text-center text-sm text-gray-500">
                    {{-- 简单插画占位，可以以后换成真正 SVG --}}
                    <div class="mb-4">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-rose-50">
                            <svg class="h-12 w-12 text-rose-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="13" rx="2" ry="2" />
                                <path d="M16 21H8" />
                                <path d="M12 17v4" />
                                <path d="M8 10h.01" />
                                <path d="M12 10h.01" />
                                <path d="M16 10h.01" />
                            </svg>
                        </div>
                    </div>

                    <p class="text-base font-medium text-gray-900">
                        No data ~
                    </p>
                    <p class="mt-1 text-sm text-gray-500">
                        You currently have no orders in this status.
                    </p>
                </div>
            @else
                {{-- 列表 --}}
                <div class="space-y-3 text-sm">
                    @foreach ($orders as $order)
                        <a href="{{ route('user.orders.show', $order) }}"
                            class="block rounded-2xl border border-gray-100 bg-gray-50/60 px-4 py-3
                              hover:bg-gray-50 hover:border-rose-200 transition">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-gray-900 text-sm">
                                            #{{ $order->order_number }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            · {{ $order->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ $order->items()->sum('quantity') }}
                                        item{{ $order->items()->sum('quantity') > 1 ? 's' : '' }}
                                        • Total:
                                        <span class="font-semibold text-gray-900">
                                            RM {{ number_format($order->total, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 text-xs justify-end">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                                            'processing' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                            'shipped' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                            'completed' => 'bg-green-50 text-green-700 ring-green-200',
                                            'cancelled' => 'bg-red-50 text-red-700 ring-red-200',
                                        ];
                                        $statusLabel = ucfirst($order->status);
                                        $statusClass =
                                            $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700 ring-gray-200';

                                        $paymentColors = [
                                            'unpaid' => 'bg-gray-50 text-gray-700 ring-gray-200',
                                            'paid' => 'bg-green-50 text-green-700 ring-green-200',
                                            'refunded' => 'bg-yellow-50 text-yellow-700 ring-yellow-200',
                                            'failed' => 'bg-red-50 text-red-700 ring-red-200',
                                        ];
                                        $paymentClass =
                                            $paymentColors[$order->payment_status] ??
                                            'bg-gray-50 text-gray-700 ring-gray-200';
                                    @endphp

                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 font-medium ring-1 {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>

                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 font-medium ring-1 {{ $paymentClass }}">
                                        Payment: {{ ucfirst($order->payment_status) }}
                                    </span>

                                    <span class="text-[11px] font-medium text-indigo-600">
                                        View details →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
