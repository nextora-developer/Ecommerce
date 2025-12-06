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
                    <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-gray-900">
                        Shop
                    </a>

                    {{-- Featured --}}
                    <a href="{{ route('catalog.index') }}#featured" class="text-gray-500 hover:text-gray-900">
                        About
                    </a>
                    
                </nav>
            </div>

            {{-- 🔍 居中搜索 + 下拉建议 --}}
            <div class="flex flex-1 items-center justify-center">
                <form action="{{ route('shop.index') }}" method="GET"
                    class="hidden sm:flex items-center w-full max-w-xl relative">
                    <input id="global-search-input" type="text" name="q" placeholder="Search products..."
                        value="{{ request('q') }}" autocomplete="off"
                        class="w-full rounded-full border border-gray-300 px-4 py-2 text-sm
                   shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400" />

                    {{-- 下拉建议列表 --}}
                    <div id="global-search-results"
                        class="absolute left-0 top-[110%] z-30 w-full rounded-xl border border-gray-200 bg-white shadow-lg text-sm hidden">
                        {{-- JS 会动态填充这里 --}}
                    </div>
                </form>
            </div>


            <!-- 右：Cart + 用户（桌面） -->
            <div class="hidden sm:flex items-center gap-4">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}"
                    class="relative inline-flex items-center rounded-full border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="h-5 w-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V6a4 4 0 118 0v1m3 0h-14l1 12h12l1-12z" />
                    </svg>
                    <span class="ml-2">Cart</span>

                    @if ($cartCount > 0)
                        <span
                            class="ml-2 inline-flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-indigo-600 px-1 text-xs font-semibold text-white">
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

                                <x-dropdown-link href="{{ route('account.dashboard') }}">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4z" />
                                            <path d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                                        </svg>
                                        <span>Account</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('user.orders.index') }}">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 4h18v4H3z" />
                                            <path d="M6 8v12h12V8" />
                                        </svg>
                                        <span>My Orders</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('favorites.index') }}">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 21l-1.45-1.32C5.4 14.36 2 11.28 2 7.5
                    2 4.42 4.42 2 7.5 2
                    9.24 2 10.91 2.81 12 4.08
                    13.09 2.81 14.76 2 16.5 2
                    19.58 2 22 4.42 22 7.5
                    c0 3.78-3.4 6.86-8.55 12.18L12 21z" />
                                        </svg>
                                        <span>Favorites</span>
                                    </div>
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('profile.edit') }}">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4
                    -4 1.8-4 4 1.8 4 4 4z" />
                                            <path d="M6 20c0-3.3 2.7-6 6-6
                    s6 2.7 6 6" />
                                        </svg>
                                        <span>Profile</span>
                                    </div>
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M15 3h4v18h-4" />
                                                <path d="M3 12h12" />
                                            </svg>
                                            <span class="text-red-600 font-semibold">Log Out</span>
                                        </div>
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
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile 菜单 -->
    <div x-cloak x-show="open" x-trap.noscroll="open" class="fixed inset-0 z-40 sm:hidden">

        {{-- 背景遮罩：只有淡入淡出 --}}
        <div @click="open = false" x-transition.opacity.duration.150ms class="absolute inset-0 bg-black/30"></div>

        {{-- 右侧滑出面板：从右边滑入 / 滑出 --}}
        <div class="absolute right-0 top-0 flex h-full w-full max-w-xs flex-col bg-white shadow-xl"
            x-transition:enter="transform transition ease-out duration-200"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-150" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">

            {{-- Header：Logo + 关闭 --}}
            <div class="flex items-center justify-between border-b px-4 py-4">
                <a href="{{ route('catalog.index') }}" class="flex items-center" @click="open = false">
                    <span class="text-lg font-bold tracking-tight text-indigo-600">
                        EXTech<span class="text-gray-900">Shop</span>
                    </span>
                </a>

                <button @click="open = false"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>

            {{-- 搜索框 --}}
            <div class="border-b px-4 py-3">
                <form action="{{ route('shop.index') }}" method="GET" class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="4" />
                            <path d="M21 21l-4.3-4.3" />
                        </svg>
                    </span>
                    <input type="text" name="q" placeholder="Search products..."
                        class="w-full rounded-full border border-gray-200 bg-gray-50 pl-9 pr-3 py-2 text-sm
                              focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500" />
                </form>
            </div>

            {{-- Scroll 区域 --}}
            <div class="flex-1 overflow-y-auto pb-6">

                {{-- Browse 分组 --}}
                <div class="border-b px-4 py-3">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        Browse
                    </p>

                    {{-- Home --}}
                    <a href="{{ route('catalog.index') }}"
                        class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm
                          {{ request()->routeIs('catalog.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 11.5L12 4l9 7.5" />
                            <path d="M5 10v9h14v-9" />
                        </svg>
                        <span>Home</span>
                    </a>

                    {{-- Shop --}}
                    <a href="{{ route('shop.index') }}"
                        class="mt-1 flex items-center gap-3 rounded-lg px-2 py-2 text-sm
                            {{ request()->routeIs('shop.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8h12l-1 10H7L6 8z" />
                            <path d="M9 8V6a3 3 0 016 0v2" />
                        </svg>

                        <span>Shop</span>
                    </a>


                    {{-- Cart --}}
                    @php
                        $cart = session('cart', ['items' => []]);
                        $cartCount = collect($cart['items'])->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}"
                        class="mt-1 flex items-center gap-3 rounded-lg px-2 py-2 text-sm
                          {{ request()->routeIs('cart.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3h2l.6 3M7 13h10l2-7H5.6" />
                            <circle cx="9" cy="19" r="1.4" />
                            <circle cx="17" cy="19" r="1.4" />
                        </svg>
                        <span>Cart</span>
                        <span class="ml-auto text-xs text-gray-400">
                            ({{ $cartCount }})
                        </span>
                    </a>
                </div>

                {{-- Account 分组 --}}
                @auth
                    <div class="border-b px-4 py-3">
                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Account
                        </p>

                        <div class="mb-3 text-xs text-gray-500">
                            <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div>{{ Auth::user()->email }}</div>
                        </div>

                        <a href="{{ route('account.dashboard') }}"
                            class="flex items-center gap-3 rounded-lg px-2 py-2 text-sm
                                {{ request()->routeIs('account.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4S8 5.79 8 8s1.79 4 4 4z" />
                                <path d="M6 20c0-3.31 2.69-6 6-6s6 2.69 6 6" />
                            </svg>

                            <span>Account overview</span>
                        </a>

                        <a href="{{ route('user.orders.index') }}"
                            class="mt-1 flex items-center gap-3 rounded-lg px-2 py-2 text-sm
                              {{ request()->routeIs('user.orders.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 4h18v4H3z" />
                                <path d="M6 8v12h12V8" />
                            </svg>
                            <span>My Orders</span>
                        </a>

                        <a href="{{ route('favorites.index') }}"
                            class="mt-1 flex items-center gap-3 rounded-lg px-2 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4.5 7.5a4.5 4.5 0 016.4 0L12 8.6l1.1-1.1a4.5 4.5 0 116.4 6.4L12 21 4.5 13.9a4.5 4.5 0 010-6.4z" />
                            </svg>
                            <span>Favorites</span>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="mt-1 flex items-center gap-3 rounded-lg px-2 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15.2 5.2a3 3 0 014.2 4.2L9 19.8 5 20l.2-4z" />
                            </svg>
                            <span>Edit Profile</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-3 rounded-lg px-2 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                    <path d="M10 17l5-5-5-5" />
                                    <path d="M15 12H3" />
                                </svg>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                @else
                    {{-- 未登录时，直接显示 Login / Register CTA --}}
                    <div class="px-4 py-4 space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full rounded-full bg-indigo-600 py-2 text-center text-sm font-semibold text-white">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full rounded-full border border-indigo-600 py-2 text-center text-sm font-semibold text-indigo-600">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

</nav>
