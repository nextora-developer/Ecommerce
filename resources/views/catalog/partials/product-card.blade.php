{{-- resources/views/catalog/partials/product-card.blade.php --}}

@props(['product'])
<div class="group relative">
    <a href="{{ route('catalog.product', $product->slug) }}"
        class="group block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
        {{-- 图片区域 --}}
        <div class="relative bg-gray-50">
            @php
                $image = $product->primaryImage ?? $product->images->first();
            @endphp

            @if ($image && $image->path)
                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                    class="h-52 w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
            @else
                <div class="flex h-52 w-full items-center justify-center text-xs text-gray-400">
                    No image
                </div>
            @endif

            {{-- 如果有折扣就显示一个 badge --}}
            @if (!empty($product->sale_price) && $product->sale_price < $product->price)
                <div
                    class="absolute left-3 top-3 rounded-full bg-rose-500 px-2 py-0.5 text-[11px] font-semibold text-white">
                    Sale
                </div>
            @endif
        </div>

        {{-- 文本区域 --}}
        <div class="space-y-1 px-4 py-3">
            <p class="text-[11px] uppercase tracking-wide text-gray-400">
                {{ $product->category->name ?? 'Uncategorized' }}
            </p>

            <h3 class="line-clamp-1 text-sm font-semibold text-gray-900">
                {{ $product->name }}
            </h3>

            {{-- 价格 --}}
            <div class="mt-1 flex items-baseline gap-2">
                @if (!empty($product->sale_price) && $product->sale_price < $product->price)
                    <span class="text-sm font-semibold text-rose-600">
                        RM {{ number_format($product->sale_price, 2) }}
                    </span>
                    <span class="text-xs text-gray-400 line-through">
                        RM {{ number_format($product->price, 2) }}
                    </span>
                @else
                    <span class="text-sm font-semibold text-gray-900">
                        RM {{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            {{-- 小小的 CTA --}}
            <div class="mt-2 flex items-center justify-between">
                <span class="text-[11px] text-gray-400">
                    {{ $product->stock ?? 'In stock' }}
                </span>

                <span class="text-[11px] font-medium text-indigo-600 group-hover:text-indigo-700">
                    View details →
                </span>
            </div>
        </div>
    </a>

    {{-- 爱心按钮 --}}
    @auth
        @php
            // 简单做法：检查当前用户是否已收藏这个 product
            $isFavorited = auth()->user()->wishlistItems()->where('product_id', $product->id)->exists();
        @endphp

        <form method="POST" action="{{ route('wishlist.toggle', $product) }}" class="absolute right-3 top-3 z-10"
            onclick="event.stopPropagation();">
            @csrf
            <button type="submit"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/90 shadow-sm hover:bg-white">
                @if ($isFavorited)
                    {{-- 实心爱心 --}}
                    <svg class="h-4 w-4 text-rose-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6
                                       4 4 6.5 4 8.04 4 9.54 4.81 10.35 6.09 11.16
                                       4.81 12.66 4 14.2 4 16.7 4 18.7 6 18.7 8.5c0
                                       3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                @else
                    {{-- 空心爱心 --}}
                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5
                                       5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78
                                       1.06-1.06a5.5 5.5 0 000-7.78z" />
                    </svg>
                @endif
            </button>
        </form>
    @endauth
</div>
