@extends('account.layout')

@section('account-breadcrumb', 'Favorites')

@section('account-content')
    <div class="space-y-6">

        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <h1 class="text-xl font-semibold text-gray-900">
                Favorites
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Products you’ve added to your wishlist.
            </p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            @if ($products->isEmpty())
                <div
                    class="rounded-xl border border-dashed border-gray-200 bg-white px-6 py-10 text-center text-sm text-gray-500">
                    You don’t have any favorites yet.
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($products as $product)
                        @include('catalog.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
