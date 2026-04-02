<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChatController extends Controller
{
    public function index()
    {
        $customer = auth()->user();
        
        // Mark admin messages as read
        Message::where('user_id', $customer->id)
            ->whereColumn('sender_id', '!=', 'user_id')
            ->update(['is_read' => true]);

        $orders = $customer->orders()->latest()->get();

        return view('chat.index', compact('customer', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'order_id' => [
                'nullable',
                Rule::exists('orders', 'id')->where('user_id', auth()->id()),
            ],
        ]);

        $message = Message::create([
            'user_id' => auth()->id(),
            'sender_id' => auth()->id(),
            'content' => $request->content,
            'is_read' => false,
            'order_id' => $request->order_id,
        ]);

        \App\Events\MessageSent::dispatch($message, auth()->id());

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('chat.index');
    }

    public function getMessages()
    {
        $customer = auth()->user();
        
        Message::where('user_id', $customer->id)
            ->whereColumn('sender_id', '!=', 'user_id')
            ->update(['is_read' => true]);

        $messages = Message::with('order')
            ->where('user_id', $customer->id)
            ->where('is_deleted_by_customer', false)
            ->oldest()
            ->get()
            ->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'content' => $msg->content,
                    'isAdmin' => $msg->sender_id != $msg->user_id,
                    'time' => $msg->created_at->format('H:i'),
                    'isRead' => (bool)$msg->is_read,
                    'order' => $msg->order ? [
                        'id' => $msg->order->id,
                        'order_number' => 'ORD-' . str_pad($msg->order->id, 4, '0', STR_PAD_LEFT),
                        'total_price' => $msg->order->total_price,
                        'status' => $msg->order->status,
                    ] : null
                ];
            });

        return response()->json($messages);
    }

    public function clearHistory()
    {
        Message::where('user_id', auth()->id())
            ->update(['is_deleted_by_customer' => true]);

        return response()->json(['success' => true]);
    }
}
