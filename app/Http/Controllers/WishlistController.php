<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // 收藏列表页
    public function index()
    {
        $user = auth()->user();

        $products = $user->wishlistItems()
            ->with(['category', 'primaryImage'])
            ->paginate(12);

        return view('account.favorites', compact('products'));
    }

    // 点击爱心：如果有就取消，没有就添加
    public function toggle(Product $product)
    {
        $user = auth()->user();

        if ($user->wishlistItems()->where('product_id', $product->id)->exists()) {
            $user->wishlistItems()->detach($product->id);
        } else {
            $user->wishlistItems()->attach($product->id);
        }

        return back();
    }
}
