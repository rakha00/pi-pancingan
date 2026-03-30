<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Report;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('storefront.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        $order->load(['items.product', 'reports']);
        return view('storefront.orders.show', compact('order'));
    }

    public function confirm(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'shipped') {
            abort(403);
        }

        $order->update(['status' => 'delivered']);
        return back()->with('success', 'Pesanan telah dikonfirmasi diterima. Terima kasih telah berbelanja!');
    }

    public function report(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'shipped') {
            abort(403);
        }

        $request->validate([
            'reason_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Report::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'reason_type' => $request->reason_type,
            'description' => $request->description,
        ]);

        $order->update(['status' => 'reported']);

        return back()->with('success', 'Laporan masalah berhasil dikirim. Admin kami akan segera memeriksanya.');
    }
}
