<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

        return view('catalog.index', compact('categories', 'latestProducts'));
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
}
