@extends('layouts.app')

@section('content')
    <div class="bg-white pt-10 pb-20">

        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">
                    @if (request('q'))
                        Search results for “{{ request('q') }}”
                    @elseif (request('category'))
                        {{ optional($categories->firstWhere('slug', request('category')))->name ?? 'Shop' }}
                    @else
                        Shop
                    @endif
                </h1>

                @if (request('q'))
                    <p class="mt-1 text-sm text-gray-500">
                        Showing products matching “{{ request('q') }}”.
                    </p>
                @endif
            </div>


            {{-- Filter Bar --}}
            <form method="GET" class="mb-8 flex flex-wrap items-center gap-4">
                {{-- 🔍 Search --}}
                <div class="flex-1 min-w-[220px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                        class="w-full rounded-md border-gray-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                    <select name="category"
                        class="w-44 rounded-md border-gray-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}"
                                {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sort by</label>
                    <select name="sort"
                        class="w-48 rounded-md border-gray-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Newest</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High
                        </option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High →
                            Low</option>
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div class="mt-5 sm:mt-6">
                    <button type="submit"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                        Apply filters
                    </button>
                </div>

                {{-- Clear --}}
                @if (request()->hasAny(['category', 'sort']))
                    <div class="mt-5 sm:mt-6">
                        <a href="{{ route('shop.index') }}" class="text-xs text-gray-500 hover:text-gray-700">
                            Clear
                        </a>
                    </div>
                @endif
            </form>


            {{-- Products --}}
            {{-- <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($products as $product)
                    @include('catalog.partials.product-card', ['product' => $product])
                @endforeach
            </div> --}}

            {{-- Products Grid --}}
            <div id="product-grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @include('catalog.partials.product-grid-items', ['products' => $products])
            </div>

            {{-- Load more 区域 --}}
            @if ($products->hasMorePages())
                <div class="mt-8 text-center" id="load-more-wrapper">
                    <button id="load-more-btn" data-next-page="{{ $products->currentPage() + 1 }}"
                        class="inline-flex items-center rounded-full bg-gray-900 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-black/90">
                        Load more
                    </button>
                </div>
            @else
                <div class="mt-8 text-center text-xs text-gray-400">
                    You’ve reached the end.
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
