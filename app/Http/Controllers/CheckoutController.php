<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set Midtrans Configuration
        Config::$serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = config('services.midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('storefront.checkout', compact('cartItems', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Check stock
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Not enough stock for ' . $item->product->name);
            }
        }

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'shipping_address' => $request->address,
        ]);

        $itemDetails = [];

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Deduct stock
            $item->product->decrement('stock', $item->quantity);

            $itemDetails[] = [
                'id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => mb_substr($item->product->name, 0, 50),
            ];
        }

        // Clear Cart
        $user->cartItems()->delete();

        if (empty(Config::$serverKey)) {
            // Midtrans not configured, just return local success
            return redirect()->route('checkout.success', $order)->with('success', 'Order created. Midtrans is not configured, so payment is mocked.');
        }

        // Midtrans Payload
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => mb_substr($user->name, 0, 20),
                'email' => $user->email,
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            return redirect()->route('checkout.success', $order);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Payment gateway error: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('storefront.checkout-success', compact('order'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $orderId = explode('-', $request->order_id)[1]; // Format was ORDER-ID-TIME
                $order = Order::find($orderId);
                if ($order) {
                    $order->update(['status' => 'paid']);
                }
            }
        }
        
        return response()->json(['message' => 'Processed'], 200);
    }
}
