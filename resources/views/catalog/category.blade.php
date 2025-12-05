@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">Category</p>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                    @if ($category->description)
                        <p class="mt-1 text-sm text-gray-600">{{ $category->description }}</p>
                    @endif
                </div>

                <a href="{{ route('catalog.index') }}" class="text-sm text-gray-500 hover:text-gray-800">
                    ← Back to home
                </a>
            </div>

            @if ($products->isEmpty())
                <p class="text-sm text-gray-500">No products in this category yet.</p>
            @else
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($products as $product)
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
                                <div class="line-clamp-2 text-sm font-semibold text-gray-900">
                                    {{ $product->name }}
                                </div>
                                @if ($product->price)
                                    <div class="mt-2 text-sm font-bold text-indigo-700">
                                        RM {{ number_format($product->price, 2) }}
                                    </div>
                                @endif
                                <span class="mt-2 text-xs text-indigo-600 opacity-0 transition group-hover:opacity-100">
                                    View details →
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
