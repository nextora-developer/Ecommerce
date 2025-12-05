<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected function getCart()
    {
        return session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
        ]);
    }

    public function show()
    {
        $cart = $this->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $user = auth()->user();

        return view('checkout.show', [
            'cart' => $cart,
            'user' => $user,
        ]);
    }

    public function process(Request $request)
    {
        $cart = $this->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'shipping_address_line1' => ['nullable', 'string', 'max:255'],
            'shipping_city'  => ['nullable', 'string', 'max:255'],
            'shipping_state' => ['nullable', 'string', 'max:255'],
            'shipping_postcode' => ['nullable', 'string', 'max:20'],
            'shipping_country'  => ['nullable', 'string', 'max:255'],
        ]);

        // 简单写死：运费 0、折扣 0
        $subtotal = $cart['subtotal'];
        $shippingFee = 0;
        $discount = 0;
        $total = $subtotal + $shippingFee - $discount;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address_line1' => $request->shipping_address_line1,
            'shipping_address_line2' => $request->shipping_address_line2,
            'shipping_city'        => $request->shipping_city,
            'shipping_state'       => $request->shipping_state,
            'shipping_postcode'    => $request->shipping_postcode,
            'shipping_country'     => $request->shipping_country,
            'subtotal'       => $subtotal,
            'shipping_fee'   => $shippingFee,
            'discount_amount' => $discount,
            'total'          => $total,
            'payment_method' => 'manual',
            'payment_status' => 'unpaid',
        ]);

        foreach ($cart['items'] as $item) {
            OrderItem::create([
                'order_id'  => $order->id,
                'product_id' => $item['product_id'],
                'product_variant_id' => $item['variant_id'],
                'product_name'   => $item['name'],
                'variant_name'   => $item['variant'],
                'quantity'       => $item['quantity'],
                'unit_price'     => $item['price'],
                'line_total'     => $item['line_total'],
            ]);
        }

        // 清空购物车
        session()->forget('cart');

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Order created.');
    }

    public function success(Order $order)
    {
        // 确保只有下单的人可以看自己的订单
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
