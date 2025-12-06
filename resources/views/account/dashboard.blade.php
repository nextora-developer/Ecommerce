@extends('account.layout')

@section('account-breadcrumb', 'Account')

@section('account-content')
    <div class="space-y-6">

        {{-- 顶部欢迎 + 小统计 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        Hi, {{ $user->name }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Manage your orders, account details and more.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center text-sm">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <div class="text-xs text-gray-500">Orders</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $ordersCount }}
                        </div>
                    </div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <div class="text-xs text-gray-500">Favorites</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $favoritesCount }}
                        </div>
                    </div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-3">
                        <div class="text-xs text-gray-500">Addresses</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $addressesCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders 区块 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-900">Orders</h2>
                <a href="{{ route('user.orders.index') }}"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-700">
                    View all →
                </a>
            </div>

            @if ($latestOrders->isEmpty())
                <div class="rounded-lg bg-green-50 px-4 py-3 text-xs text-green-700">
                    ✓ You currently have no orders, you can start creating your first order.
                </div>
            @else
                <div class="divide-y text-sm">
                    @foreach ($latestOrders as $order)
                        <a href="{{ route('user.orders.show', $order) }}"
                            class="flex items-center justify-between py-3 hover:bg-gray-50">
                            <div>
                                <div class="font-mono text-gray-900">
                                    #{{ $order->order_number }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div class="text-right text-xs">
                                <div class="font-semibold text-gray-900">
                                    RM {{ number_format($order->total, 2) }}
                                </div>
                                <div class="text-gray-500">
                                    {{ ucfirst($order->status) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
