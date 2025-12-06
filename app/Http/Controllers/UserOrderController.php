<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // 当前 tab（all / unpaid / paid / shipped / completed / cancelled）
        $status = $request->get('status', 'all');
        $search = trim((string) $request->get('q'));

        $query = Order::where('user_id', $userId)->latest();

        // 根据当前 tab 过滤
        switch ($status) {
            case 'unpaid':
                $query->where('payment_status', 'unpaid');
                break;
            case 'paid':
                $query->where('payment_status', 'paid');
                break;
            case 'shipped':
                $query->where('status', 'shipped');
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            case 'cancelled':
                $query->where('status', 'cancelled');
                break;
            case 'all':
            default:
                // 不加过滤
                break;
        }

        if ($search !== '') {
            $query->where('order_number', 'like', "%{$search}%");
        }

        $orders = $query->paginate(10)->withQueryString();

        // 各 tab 的数量（可以用在 Tab 上）
        $base = Order::where('user_id', $userId);

        $counts = [
            'all'       => (clone $base)->count(),
            'unpaid'    => (clone $base)->where('payment_status', 'unpaid')->count(),
            'paid'      => (clone $base)->where('payment_status', 'paid')->count(),
            'shipped'   => (clone $base)->where('status', 'shipped')->count(),
            'completed' => (clone $base)->where('status', 'completed')->count(),
            'cancelled' => (clone $base)->where('status', 'cancelled')->count(),
        ];

        return view('orders.index', [
            'orders'       => $orders,
            'activeStatus' => $status,
            'search'       => $search,
            'counts'       => $counts,
        ]);
    }

    public function show(Order $order)
    {
        // 确保用户只能看自己的订单
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'items.variant']);

        return view('orders.show', compact('order'));
    }
}
