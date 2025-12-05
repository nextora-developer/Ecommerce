@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <!-- Hero -->
        <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 py-10 sm:flex-row sm:items-center sm:py-14 lg:px-8">
                <div class="flex-1">
                    <p class="mb-2 inline-flex items-center rounded-full bg-white/10 px-3 py-1 text-xs font-medium">
                        New • Laravel + Filament Ecommerce
                    </p>
                    <h1 class="text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">
                        Simple ecommerce starter for your next project
                    </h1>
                    <p class="mt-3 max-w-xl text-sm text-indigo-100 sm:text-base">
                        Browse products, add to cart, checkout with your customers.
                        This front-end is built on Laravel Breeze + Tailwind CSS.
                    </p>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <a href="#featured-products"
                            class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow hover:bg-indigo-50">
                            Start Shopping
                        </a>
                        <a href="#categories" class="text-sm font-medium text-white/80 hover:text-white">
                            View Categories →
                        </a>
                    </div>
                </div>

                <div class="flex flex-1 justify-center">
                    <div class="relative w-full max-w-sm rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <div class="mb-3 text-xs font-medium uppercase tracking-wide text-indigo-100">
                            Live preview
                        </div>
                        <div class="space-y-3 rounded-xl bg-white p-4 text-gray-900 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-medium text-gray-500">Cart total</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        RM {{ number_format($latestProducts->take(3)->sum('price') ?? 0, 2) }}
                                    </div>
                                </div>
                                <div class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                                    Sample
                                </div>
                            </div>
                            <div class="border-t pt-3 text-xs text-gray-500">
                                This is just a mock card to make hero look like ecommerce UI.
                            </div>
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
                                        <img src="{{ asset($product->primaryImage->path) }}" alt="{{ $product->name }}"
                                            class="h-full w-full object-cover">
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
    </div>
@endsection
