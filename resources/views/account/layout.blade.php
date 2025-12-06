@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="mb-6 flex items-center gap-1 text-xs text-gray-500">
                <a href="{{ route('catalog.index') }}" class="hover:text-gray-800">Home</a>
                <span>/</span>
                <span class="text-gray-700">
                    @yield('account-breadcrumb', 'Account')
                </span>
            </nav>

            {{-- 左侧导航 + 右侧内容 --}}
            <div class="flex gap-8 items-start">
                {{-- 左侧：Account Sidebar --}}
                <aside
                    class="hidden w-64 flex-shrink-0 rounded-2xl border border-gray-200 bg-white shadow-sm
                           lg:block self-start">

                    {{-- 顶部用户信息 --}}
                    <div class="border-b border-gray-100 px-6 pt-6 pb-5">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-500">
                                {{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">
                                    Hi, {{ auth()->user()->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ auth()->user()->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $items = [
                            [
                                'label' => 'Account',
                                'route' => 'account.dashboard',
                                'icon' => 'M5 4h14M5 9h14M5 14h14',
                            ],
                            [
                                'label' => 'Orders',
                                'route' => 'user.orders.index',
                                'icon' => 'M3 3h2l.4 2M7 13h10l3-7H6.4M7 13l-2 9m5-9v9m4-9v9m4-9l2 9',
                            ],
                            [
                                'label' => 'Favorites',
                                'route' => null,
                                'icon' =>
                                    'M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364 4.318 12.682a4.5 4.5 0 010-6.364z',
                            ],
                            [
                                'label' => 'Addresses',
                                'route' => null,
                                'icon' => 'M12 2a7 7 0 00-7 7c0 5.25 7 11 7 11s7-5.75 7-11a7 7 0 00-7-7z',
                            ],
                            [
                                'label' => 'Edit Profile',
                                'route' => 'profile.edit',
                                'icon' => 'M15.232 5.232a3 3 0 114.243 4.243L7.5 21H3v-4.5l12.232-11.268z',
                            ],
                        ];
                    @endphp

                    {{-- 菜单 --}}
                    <nav class="px-6 py-6 space-y-4 text-[15px]">
                        @foreach ($items as $item)
                            @php
                                $isActive = $item['route'] && request()->routeIs($item['route'] . '*');
                            @endphp

                            <a href="{{ $item['route'] ? route($item['route']) : '#' }}"
                                class="flex items-center gap-4 rounded-lg px-0 py-2.5
                                      {{ $isActive ? 'bg-rose-50 text-rose-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $item['icon'] }}" />
                                </svg>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endforeach

                        {{-- 分隔线 --}}
                        <hr class="border-gray-200 my-3">

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="pt-1">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-4 rounded-lg px-0 py-2.5 text-left text-gray-700 hover:bg-gray-50">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                    <path d="M10 17l5-5-5-5" />
                                    <path d="M15 12H3" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </nav>
                </aside>

                {{-- 右侧内容区域 --}}
                <main class="flex-1 pb-10">
                    @yield('account-content')
                </main>
            </div>
        </div>
    </div>
@endsection
