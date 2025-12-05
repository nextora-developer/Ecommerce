@extends('layouts.app') {{-- 用 Breeze 的布局 --}}

@section('content')
    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Catalog</h1>

        <h2 class="text-xl font-semibold mb-2">Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @foreach ($categories as $category)
                <a href="{{ route('catalog.category', $category->slug) }}" class="border rounded p-3 hover:bg-gray-50 block">
                    <div class="font-semibold">{{ $category->name }}</div>
                    <div class="text-xs text-gray-500">
                        {{ $category->products->count() }} products
                    </div>
                </a>
            @endforeach
        </div>

        <h2 class="text-xl font-semibold mb-2">Latest Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($latestProducts as $product)
                <a href="{{ route('catalog.product', $product->slug) }}" class="border rounded p-3 hover:bg-gray-50 block">
                    <div class="mb-2 h-32 bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                        @if ($product->primaryImage)
                            <img src="{{ asset($product->primaryImage->path) }}" alt="{{ $product->name }}"
                                class="max-h-32">
                        @else
                            No Image
                        @endif
                    </div>
                    <div class="font-semibold text-sm">{{ $product->name }}</div>
                    @if ($product->price)
                        <div class="text-sm text-gray-700">RM {{ number_format($product->price, 2) }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endsection
