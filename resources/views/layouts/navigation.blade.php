<nav x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-100">
    @php
        $cart = session('cart', ['items' => []]);
        $cartCount = collect($cart['items'])->sum('quantity');
    @endphp

    <!-- Desktop / 主导航 -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-8">
            <!-- 左：Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('catalog.index') }}" class="flex items-center">
                    <span class="text-xl font-bold tracking-tight text-indigo-600">
                        EXTech<span class="text-gray-900">Shop</span>
                    </span>
                </a>

                <!-- 中：主菜单（桌面） -->
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    {{-- Home --}}
                    <a href="{{ route('catalog.index') }}"
                       class="{{ request()->routeIs('catalog.index') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                        Home
                    </a>

                    {{-- Shop：跳到商品区 --}}
                    <a href="{{ route('catalog.index') }}#shop"
                       class="text-gray-500 hover:text-gray-900">
                        Shop
                    </a>

                    {{-- Featured --}}
                    <a href="{{ route('catalog.index') }}#featured"
                       class="text-gray-500 hover:text-gray-900">
                        Featured
                    </a>

                    {{-- Deals --}}
                    <a href="{{ route('catalog.index') }}#deals"
                       class="text-gray-500 hover:text-gray-900">
                        Deals
                    </a>
                </nav>
            </div>

            <!-- 右：Cart + 用户（桌面） -->
            <div class="hidden sm:flex items-center gap-4">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.8" stroke="currentColor" class="h-5 w-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V6a4 4 0 118 0v1m3 0h-14l1 12h12l1-12z" />
                    </svg>
                    <span class="ml-2">Cart</span>

                    @if ($cartCount > 0)
                        <span class="ml-2 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-indigo-600 px-1 text-xs font-semibold text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- 用户 / 登录 -->
                <div class="flex items-center">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Login
                        </a>
                        <span class="mx-2 text-gray-300">|</span>
                        <a href="{{ route('register') }}"
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                            Register
                        </a>
                    @endguest

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <span class="mr-1">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Account
                                </div>

                                <x-dropdown-link href="{{ route('account.dashboard') }}">
                                    Account
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('user.orders.index') }}">
                                    My Orders
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('profile.edit') }}">
                                    Profile
                                </x-dropdown-link>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>
            </div>

            <!-- Mobile 汉堡按钮 -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile 菜单 -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden border-t border-gray-100">
        <div class="space-y-1 pt-2 pb-3">
            {{-- Home --}}
            <a href="{{ route('catalog.index') }}"
               class="block px-4 py-2 text-base font-medium
                      {{ request()->routeIs('catalog.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                Home
            </a>

            {{-- Shop --}}
            <a href="{{ route('catalog.index') }}#shop"
               class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                Shop
            </a>

            {{-- Featured --}}
            <a href="{{ route('catalog.index') }}#featured"
               class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                Featured
            </a>

            {{-- Deals --}}
            <a href="{{ route('catalog.index') }}#deals"
               class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                Deals
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}"
               class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                Cart ({{ $cartCount }})
            </a>
        </div>

        <!-- Mobile 用户部分 -->
        <div class="border-t border-gray-100 pt-4 pb-3">
            @auth
                <div class="px-4 mb-2">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            @endauth

            <div class="mt-1 space-y-1">
                @guest
                    <a href="{{ route('login') }}"
                       class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block px-4 py-2 text-base font-medium text-indigo-600 hover:bg-gray-50 hover:text-indigo-700">
                        Register
                    </a>
                @endguest

                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="block w-full px-4 py-2 text-left text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                            Log Out
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
