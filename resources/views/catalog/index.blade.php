@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        {{-- Hero Section --}}
        @if ($heroBanners->isNotEmpty())
            <section class="relative overflow-hidden">
                <div class="hero-swiper h-[60vh] lg:h-[70vh]">
                    <div class="swiper-wrapper">
                        @foreach ($heroBanners as $banner)
                            <div class="swiper-slide">
                                <div class="relative h-[70vh] lg:h-[80vh] overflow-hidden">
                                    {{-- 背景图 --}}
                                    @if ($banner->image_url)
                                        <div class="absolute inset-0">
                                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                                                class="h-full w-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/30 to-transparent">
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
                                        </div>
                                    @endif

                                    {{-- 内容 --}}
                                    <div
                                        class="relative mx-auto flex h-full max-w-7xl items-center px-4 py-16 lg:px-8 lg:py-24">
                                        <div class="max-w-xl space-y-6 text-white">
                                            @if ($banner->eyebrow)
                                                <span
                                                    class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium uppercase tracking-wide">
                                                    {{ $banner->eyebrow }}
                                                </span>
                                            @endif

                                            <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl">
                                                {{ $banner->title }}
                                            </h1>

                                            @if ($banner->subtitle)
                                                <p class="max-w-lg text-sm sm:text-base text-white/80">
                                                    {{ $banner->subtitle }}
                                                </p>
                                            @endif

                                            <div class="flex flex-wrap gap-3 pt-2">
                                                @if ($banner->primary_button_label && $banner->primary_button_url)
                                                    <a href="{{ $banner->primary_button_url }}"
                                                        class="inline-flex items-center rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-gray-100">
                                                        {{ $banner->primary_button_label }}
                                                    </a>
                                                @endif

                                                @if ($banner->secondary_button_label && $banner->secondary_button_url)
                                                    <a href="{{ $banner->secondary_button_url }}"
                                                        class="inline-flex items-center rounded-full border border-white/70 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/15">
                                                        {{ $banner->secondary_button_label }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination dots --}}
                    <div
                        class="hero-swiper-pagination absolute bottom-5 left-1/2 z-10 flex -translate-x-1/2 justify-center">
                    </div>

                    {{-- 左右箭头（可选） --}}
                    <button
                        class="hero-swiper-prev absolute left-4 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm hover:bg-black/50 lg:inline-flex">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                    </button>
                    <button
                        class="hero-swiper-next absolute right-4 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-black/30 p-2 text-white backdrop-blur-sm hover:bg-black/50 lg:inline-flex">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 6l6 6-6 6" />
                        </svg>
                    </button>
                </div>
            </section>
        @else
            {{-- 没有任何 hero_banners 时，用原来静态的紫色 banner 当 fallback --}}
            <section class="relative min-h-[70vh] lg:min-h-[80vh] overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500"></div>
                <div class="relative mx-auto flex h-full max-w-7xl items-center px-4 py-16 lg:px-8 lg:py-24">
                    <div class="max-w-xl space-y-6 text-white">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium uppercase tracking-wide">
                            New • Laravel + Filament Ecommerce
                        </span>
                        <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl lg:text-5xl">
                            Simple ecommerce starter for your next project
                        </h1>
                        <p class="max-w-lg text-sm sm:text-base text-white/80">
                            Browse products, add to cart, checkout with your customers. This front-end is built on Laravel
                            Breeze + Tailwind CSS.
                        </p>
                        <div class="flex flex-wrap gap-3 pt-2">
                            <a href="{{ route('shop.index') }}"
                                class="inline-flex items-center rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-gray-100">
                                Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif



        {{-- Trust / selling points --}}
        <section class="bg-gray-50">
            <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
                <div class="grid gap-6 md:grid-cols-4">

                    {{-- 1. Free shipping --}}
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 text-violet-600 text-lg">
                            🚚
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Free shipping</div>
                            <p class="mt-1 text-xs text-gray-500">
                                Enjoy free delivery on orders over <span class="font-medium">RM 80</span>.
                            </p>
                        </div>
                    </div>

                    {{-- 2. Easy returns --}}
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 text-violet-600 text-lg">
                            🔄
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">7-day returns</div>
                            <p class="mt-1 text-xs text-gray-500">
                                Changed your mind? Return items within 7 days.
                            </p>
                        </div>
                    </div>

                    {{-- 3. Secure checkout --}}
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 text-violet-600 text-lg">
                            🔒
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Secure checkout</div>
                            <p class="mt-1 text-xs text-gray-500">
                                Payments are encrypted and processed securely.
                            </p>
                        </div>
                    </div>

                    {{-- 4. Local support --}}
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-4 shadow-sm">
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 text-violet-600 text-lg">
                            💬
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Fast support</div>
                            <p class="mt-1 text-xs text-gray-500">
                                Need help? Chat with us on WhatsApp.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- 分类 -->
        <section id="categories" class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Browse by category</h2>
            </div>

            @if ($categories->isEmpty())
                <p class="text-sm text-gray-500">No categories yet. Create some in Filament → Catalog → Categories.</p>
            @else
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($categories as $category)
                        <a href="{{ route('catalog.category', $category->slug) }}"
                            class="group flex flex-col rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-400 hover:shadow-md">
                            <div
                                class="mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                                {{ Str::upper(Str::substr($category->name, 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ $category->name }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $category->products->count() }} products
                                </div>
                            </div>
                            <span
                                class="mt-2 text-xs font-medium text-indigo-600 opacity-0 transition group-hover:opacity-100">
                                Shop now →
                            </span>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- 推荐商品 -->
        <section id="featured-products" class="bg-white">
            <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Latest products</h2>
                </div>

                @if ($latestProducts->isEmpty())
                    <p class="text-sm text-gray-500">No products yet. Create some in Filament → Catalog → Products.</p>
                @else
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($latestProducts as $product)
                            <a href="{{ route('catalog.product', $product->slug) }}"
                                class="group flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-400 hover:shadow-md">
                                <div class="relative h-40 w-full bg-gray-100">
                                    @if ($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                            alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">
                                            No image
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-1 flex-col p-3">
                                    <div class="text-xs text-gray-500">
                                        {{ $product->category?->name ?? 'Uncategorized' }}
                                    </div>
                                    <div class="mt-1 line-clamp-2 text-sm font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </div>
                                    @if ($product->price)
                                        <div class="mt-2 text-sm font-bold text-indigo-700">
                                            RM {{ number_format($product->price, 2) }}
                                        </div>
                                    @endif
                                    <button
                                        class="mt-3 inline-flex items-center justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white opacity-0 transition group-hover:opacity-100">
                                        View details
                                    </button>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        {{-- ==== All Products / Shop ==== --}}
        {{-- <section id="shop" class="mt-14">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Shop</h2>
                <p class="text-xs text-gray-500">Browse all products</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($latestProducts as $product)
                    @include('catalog.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section> --}}

        {{-- ==== Featured Products ==== --}}
        {{-- @if ($featuredProducts->isNotEmpty())
            <section id="featured" class="mt-14">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-indigo-600">Featured Picks</h2>
                    <p class="text-xs text-gray-500">Selected items we think you’ll love</p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredProducts as $product)
                        @include('catalog.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif --}}

        {{-- ==== Deals / On Sale ==== --}}
        {{-- @if ($dealProducts->isNotEmpty())
            <section id="deals" class="mt-14 mb-14">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-indigo-600">Deals & Offers</h2>
                    <p class="text-xs text-gray-500">Limited-time price drops available now</p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($dealProducts as $product)
                        @include('catalog.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </section>
        @endif --}}

    </div>
@endsection
