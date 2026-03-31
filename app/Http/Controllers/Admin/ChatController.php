<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Get all customers who have at least one message
        $customers = User::where('role', 'customer')
            ->whereHas('messages')
            ->withCount(['messages as unread_count' => function ($query) {
                // Unread messages from customer (sender_id == user_id)
                $query->whereColumn('sender_id', 'user_id')->where('is_read', false);
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->messages()->latest()->first()->created_at;
            });

        return view('admin.chats.index', compact('customers'));
    }

    public function show(User $customer)
    {
        // Mark messages from customer as read
        Message::where('user_id', $customer->id)
            ->whereColumn('sender_id', 'user_id')
            ->update(['is_read' => true]);

        return view('admin.chats.show', compact('customer'));
    }

    public function store(Request $request, User $customer)
    {
        $request->validate(['content' => 'required|string']);

        $message = Message::create([
            'user_id' => $customer->id,
            'sender_id' => auth()->id(),
            'content' => $request->content,
            'is_read' => false,
        ]);

        \App\Events\MessageSent::dispatch($message, $customer->id);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.chats.show', $customer);
    }

    public function getMessages(User $customer)
    {
        Message::where('user_id', $customer->id)
            ->whereColumn('sender_id', 'user_id')
            ->update(['is_read' => true]);

        $messages = Message::where('user_id', $customer->id)->oldest()->get()->map(function($msg) {
            return [
                'id' => $msg->id,
                'content' => $msg->content,
                'isAdmin' => $msg->sender_id != $msg->user_id,
                'time' => $msg->created_at->format('H:i'),
                'isRead' => (bool)$msg->is_read
            ];
        });

        return response()->json($messages);
    }
}
