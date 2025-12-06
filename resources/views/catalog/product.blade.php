@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">
            <a href="{{ url()->previous() }}" class="mb-4 inline-flex items-center text-xs text-gray-500 hover:text-gray-800">
                ← Back
            </a>

            <div class="grid gap-8 md:grid-cols-2">
                <!-- 图片 -->
                <div>
                    @if ($product->images->count())
                        <div class="aspect-square overflow-hidden rounded-2xl bg-white shadow">
                            <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover">
                        </div>
                        @if ($product->images->count() > 1)
                            <div class="mt-3 flex gap-2">
                                @foreach ($product->images as $image)
                                    <div class="h-16 w-16 overflow-hidden rounded-lg border bg-gray-100">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt=""
                                            class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div
                            class="flex aspect-square items-center justify-center rounded-2xl bg-white text-gray-400 shadow">
                            No image
                        </div>
                    @endif
                </div>

                <!-- 信息 + 加入购物车 -->
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-indigo-600">
                        {{ $product->category?->name ?? 'Product' }}
                    </p>
                    <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <div class="mt-3 flex items-center gap-3">
                        @if ($product->price)
                            <div class="text-2xl font-semibold text-indigo-700">
                                RM {{ number_format($product->price, 2) }}
                            </div>
                        @endif
                    </div>

                    @if ($product->short_description)
                        <p class="mt-2 text-sm text-gray-600">
                            {{ $product->short_description }}
                        </p>
                    @endif

                    <form action="{{ route('cart.add') }}" method="POST"
                        class="mt-6 space-y-4 rounded-2xl bg-white p-4 shadow">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        @if ($product->variants->count())
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Variant</label>
                                <select name="variant_id"
                                    class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($product->variants as $variant)
                                        <option value="{{ $variant->id }}">
                                            {{ $variant->name }}
                                            @if ($variant->price)
                                                - RM {{ number_format($variant->price, 2) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1"
                                    class="w-20 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <button type="submit"
                                class="mt-6 inline-flex flex-1 items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700">
                                Add to Cart
                            </button>
                        </div>
                    </form>

                    @if ($product->description)
                        <div class="mt-8 rounded-2xl bg-white p-4 shadow">
                            <h2 class="mb-2 text-sm font-semibold text-gray-900">Product details</h2>
                            <div class="prose max-w-none text-sm">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
