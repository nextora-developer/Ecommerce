<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $ordersCount    = Order::where('user_id', $user->id)->count();
        $favoritesCount = 0; // 以后你做 favorites 再改
        $addressesCount = 0; // 以后做 address 再改

        $latestOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        return view('account.dashboard', compact(
            'user',
            'ordersCount',
            'favoritesCount',
            'addressesCount',
            'latestOrders',
        ));
    }
}
