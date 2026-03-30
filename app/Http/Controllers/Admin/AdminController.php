<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $revenue = Order::where('status', 'paid')->sum('total_price');
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('revenue', 'ordersCount', 'productsCount', 'recentOrders'));
    }
}
