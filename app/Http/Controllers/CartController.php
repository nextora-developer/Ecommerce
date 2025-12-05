<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function getCart()
    {
        return session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
        ]);
    }

    protected function saveCart($cart)
    {
        // 重新计算 subtotal
        $cart['subtotal'] = collect($cart['items'])->sum('line_total');
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $variant = null;
        $price = $product->price;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::findOrFail($request->variant_id);
            $price = $variant->price ?? $price;
        }

        if ($price === null) {
            return back()->with('error', 'This product has no price set.');
        }

        $cart = $this->getCart();

        $key = $product->id . '-' . ($variant?->id ?? '0');

        if (isset($cart['items'][$key])) {
            $cart['items'][$key]['quantity'] += $request->quantity;
        } else {
            $cart['items'][$key] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name'       => $product->name,
                'variant'    => $variant?->name,
                'price'      => $price,
                'quantity'   => $request->quantity,
                'line_total' => 0, // 稍后算
            ];
        }

        $cart['items'][$key]['line_total'] =
            $cart['items'][$key]['quantity'] * $cart['items'][$key]['price'];

        $this->saveCart($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Item added to cart.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart();

        if (! isset($cart['items'][$request->key])) {
            return back()->with('error', 'Item not found in cart.');
        }

        $cart['items'][$request->key]['quantity'] = $request->quantity;
        $cart['items'][$request->key]['line_total'] =
            $request->quantity * $cart['items'][$request->key]['price'];

        $this->saveCart($cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
        ]);

        $cart = $this->getCart();
        unset($cart['items'][$request->key]);

        $this->saveCart($cart);

        return back()->with('success', 'Item removed.');
    }
}
