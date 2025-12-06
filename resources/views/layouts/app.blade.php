<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @isset($slot)
                {{-- 用于 <x-app-layout> 组件 --}}
                {{ $slot }}
            @else
                {{-- 用于 @extends('layouts.app') + @section('content') --}}
                @yield('content')
            @endisset
        </main>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function setupSearch(inputId, boxId) {
            const input = document.getElementById(inputId);
            const box = document.getElementById(boxId);

            if (!input || !box) return;

            let timer = null;

            function hideBox() {
                box.classList.add('hidden');
                box.innerHTML = '';
            }

            function renderSuggestions(items) {
                box.innerHTML = '';

                if (!items.length) {
                    hideBox();
                    return;
                }

                items.forEach(item => {
                    const link = document.createElement('a');
                    link.href = item.url;
                    link.className = 'block px-3 py-2 hover:bg-gray-50 cursor-pointer';

                    link.innerHTML = `
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-gray-800 line-clamp-1">${item.name}</span>
                        <span class="text-xs text-gray-500">RM ${item.price}</span>
                    </div>
                `;

                    box.appendChild(link);
                });

                box.classList.remove('hidden');
            }

            async function fetchSuggestions(q) {
                if (q.length < 2) {
                    hideBox();
                    return;
                }

                try {
                    const res = await fetch(`{{ route('search.suggestions') }}?q=` + encodeURIComponent(q));
                    if (!res.ok) return;

                    const data = await res.json();
                    renderSuggestions(data);
                } catch (e) {
                    console.error(e);
                }
            }

            input.addEventListener('input', function(e) {
                const value = e.target.value;

                clearTimeout(timer);
                timer = setTimeout(() => fetchSuggestions(value), 200); // debounce
            });

            input.addEventListener('focus', function() {
                if (box.innerHTML.trim() !== '') {
                    box.classList.remove('hidden');
                }
            });

            // 点击别处收起
            document.addEventListener('click', function(e) {
                if (!box.contains(e.target) && e.target !== input) {
                    hideBox();
                }
            });
        }

        // 🔍 Desktop nav search
        setupSearch('global-search-input', 'global-search-results');

        // 📱 Mobile drawer search
        setupSearch('mobile-search-input', 'mobile-search-results');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('product-grid');
        const btn = document.getElementById('load-more-btn');
        const wrapper = document.getElementById('load-more-wrapper');

        if (!grid || !btn) return;

        const baseUrl = "{{ route('shop.index') }}";
        const baseQuery = new URLSearchParams(@json(request()->query())); // 保留 q / category / sort

        let loading = false;

        async function loadMore() {
            if (loading) return;
            loading = true;

            const nextPage = btn.dataset.nextPage;
            if (!nextPage) {
                wrapper.remove();
                return;
            }

            // 按钮状态
            btn.disabled = true;
            btn.innerText = 'Loading...';

            const params = new URLSearchParams(baseQuery.toString());
            params.set('page', nextPage);

            const url = baseUrl + '?' + params.toString();

            try {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!res.ok) {
                    throw new Error('Failed to load');
                }

                const data = await res.json();

                // 把新产品 append 到 grid
                grid.insertAdjacentHTML('beforeend', data.html);

                if (data.next_page) {
                    const urlObj = new URL(data.next_page);
                    const newPage = urlObj.searchParams.get('page') || (parseInt(nextPage, 10) + 1);
                    btn.dataset.nextPage = newPage;
                    btn.disabled = false;
                    btn.innerText = 'Load more';
                } else {
                    // 没有下一页了，移除按钮
                    wrapper.remove();
                }
            } catch (e) {
                console.error(e);
                btn.disabled = false;
                btn.innerText = 'Try again';
            } finally {
                loading = false;
            }
        }

        btn.addEventListener('click', function() {
            loadMore();
        });

        
    });
</script>



<footer class="bg-gradient-to-r from-[#7F56D9] to-[#6246EA] text-white mt-20">
    <div class="mx-auto max-w-7xl px-6 py-14">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="space-y-3">
                <h3 class="text-lg font-semibold tracking-wide">EXTechShop</h3>
                <p class="text-sm text-purple-100 leading-relaxed">
                    Your next ecommerce project, built with Laravel + Filament.
                </p>
            </div>

            {{-- Shop --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold">Shop</h3>
                <ul class="space-y-2 text-sm text-purple-100">
                    <li><a href="#" class="hover:text-white">Categories</a></li>
                    <li><a href="#" class="hover:text-white">New Products</a></li>
                    <li><a href="#" class="hover:text-white">Best Sellers</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold">Support</h3>
                <ul class="space-y-2 text-sm text-purple-100">
                    <li><a href="#" class="hover:text-white">Order Tracking</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            {{-- Social --}}
            <div class="space-y-3">
                <h3 class="text-sm font-semibold">Follow us</h3>
                <div class="flex gap-4 text-xl">
                    <a href="#" class="hover:text-white">🌐</a>
                    <a href="#" class="hover:text-white">📘</a>
                    <a href="#" class="hover:text-white">📷</a>
                </div>
            </div>

        </div>

        <div class="mt-10 border-t border-white/20 pt-6 text-center text-sm text-purple-100">
            © {{ date('Y') }} EXTechShop – All rights reserved.
        </div>
    </div>
</footer>



</html>
