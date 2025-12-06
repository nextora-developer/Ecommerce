<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with(['products' => function ($q) {
                $q->where('is_active', true)->limit(8);
            }])
            ->get();

        $latestProducts = Product::where('is_active', true)
            ->latest()
            ->take(12)
            ->with('primaryImage')
            ->get();

        $heroBanners = HeroBanner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')          // 先按 sort_order
            ->orderByDesc('updated_at')      // 再按更新时间
            ->get();

        return view('catalog.index', compact('categories', 'latestProducts', 'heroBanners'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->where('is_active', true)
            ->with('primaryImage')
            ->paginate(12);

        return view('catalog.category', compact('category', 'products'));
    }

    public function product(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'variants'])
            ->firstOrFail();

        return view('catalog.product', compact('product'));
    }

    public function shop(Request $request)
    {
        $query = Product::with(['category', 'primaryImage']);

        // 🔍 Search
        if ($request->filled('q')) {
            $keyword = '%' . $request->q . '%';

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', $keyword);

                // 如果你有这两个字段就保留，没有就可以先删掉
                // $q->orWhere('sku', 'like', $keyword);
                // $q->orWhere('short_description', 'like', $keyword);
            });
        }

        // Category filter by slug
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sort
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest(); // 默认 newest
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        // 如果是 ajax 请求，返回局部 HTML + 下一页链接
        if ($request->ajax()) {
            $html = view('catalog.partials.product-grid-items', compact('products'))->render();

            return response()->json([
                'html'      => $html,
                'next_page' => $products->nextPageUrl(),
            ]);
        }

        return view('catalog.shop', compact('products', 'categories'));
    }

    public function suggestions(Request $request)
    {
        $term = trim($request->get('q', ''));

        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $keyword = '%' . $term . '%';

        $products = Product::select('id', 'name', 'slug', 'price')
            ->where('name', 'like', $keyword)
            // 这里以后可以加 SKU/描述搜索
            ->orderBy('name')
            ->limit(6)
            ->get()
            ->map(function ($product) {
                return [
                    'id'    => $product->id,
                    'name'  => $product->name,
                    'price' => number_format($product->price, 2),
                    'url'   => route('catalog.product', $product->slug),
                ];
            });

        return response()->json($products);
    }
}
