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
