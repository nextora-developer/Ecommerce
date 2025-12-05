@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                @if ($product->images->count())
                    <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full mb-3">
                    <div class="flex gap-2">
                        @foreach ($product->images as $image)
                            <img src="{{ asset($image->path) }}" alt="" class="h-16 w-16 object-cover border">
                        @endforeach
                    </div>
                @else
                    <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>

                @if ($product->price)
                    <div class="text-xl text-green-700 mb-2">
                        RM {{ number_format($product->price, 2) }}
                    </div>
                @endif

                @if ($product->short_description)
                    <p class="text-gray-700 mb-4">{{ $product->short_description }}</p>
                @endif

                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    @if ($product->variants->count())
                        <div>
                            <label class="block text-sm font-semibold mb-1">Variant</label>
                            <select name="variant_id" class="border rounded w-full px-2 py-1">
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

                    <div>
                        <label class="block text-sm font-semibold mb-1">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1"
                            class="border rounded w-24 px-2 py-1">
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Add to Cart
                    </button>
                </form>

                @if ($product->description)
                    <div class="mt-6 prose max-w-none">
                        {!! $product->description !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
