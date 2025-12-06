{{-- 只渲染一批产品卡片，用在第一页 + ajax append --}}
@foreach ($products as $product)
    @include('catalog.partials.product-card', ['product' => $product])
@endforeach
