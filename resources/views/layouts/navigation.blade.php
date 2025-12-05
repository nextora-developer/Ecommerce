<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <!-- 顶部 -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <!-- 左边：Logo + 主菜单 -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('catalog.index') }}">
                        <span class="text-xl font-bold tracking-tight text-indigo-600">
                            EXTech<span class="text-gray-900">Shop</span>
                        </span>
                    </a>
                </div>

                <!-- 桌面菜单 -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('catalog.index') }}"
                        class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium
                              {{ request()->routeIs('catalog.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        Home
                    </a>

                    {{-- 你之后可以做一个 Category 全部列表页面 --}}
                    {{-- <a href="#" class="inline-flex ...">All Categories</a> --}}

                    @auth
                        <a href="{{ route('checkout.show') }}"
                            class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium
                                  {{ request()->routeIs('checkout.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            My Orders
                        </a>
                    @endauth
                </div>
            </div>

            <!-- 右边：Cart + 用户 -->
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                @php
                    $cart = session('cart', ['items' => []]);
                    $cartCount = collect($cart['items'])->sum('quantity');
                @endphp

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13l-1.6-8M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
                    </svg>
                    <span class="ml-2">Cart</span>
                    @if ($cartCount > 0)
                        <span
                            class="ml-2 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-indigo-600 px-1 text-xs font-semibold text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- 登录 / 用户 Dropdown -->
                <div class="ms-4 flex items-center">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Login
                        </a>
                        <span class="mx-2 text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                            Register
                        </a>
                    @endguest

                    @auth
                        <!-- Settings Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="h-4 w-4 fill-current text-gray-400" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Account
                                </div>

                                <x-dropdown-link href="{{ route('profile.edit') }}">
                                    Profile
                                </x-dropdown-link>

                                <!-- Authentication -->
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

            <!-- Mobile Menu Button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="space-y-1 pt-2 pb-3">
            <a href="{{ route('catalog.index') }}"
                class="block border-l-4 px-4 py-2 text-base font-medium
                      {{ request()->routeIs('catalog.index') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800' }}">
                Home
            </a>
            <a href="{{ route('cart.index') }}"
                class="block border-l-4 px-4 py-2 text-base font-medium border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800">
                Cart ({{ $cartCount }})
            </a>
        </div>

        <!-- Mobile user info -->
        <div class="border-t border-gray-200 pt-4 pb-3">
            @auth
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            @endauth

            <div class="mt-3 space-y-1">
                @guest
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 text-base font-medium text-indigo-600 hover:bg-gray-100 hover:text-indigo-700">
                        Register
                    </a>
                @endguest

                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="block w-full px-4 py-2 text-left text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800">
                            Log Out
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
