<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $customer = auth()->user();
        
        // Mark admin messages as read
        Message::where('user_id', $customer->id)
            ->whereColumn('sender_id', '!=', 'user_id')
            ->update(['is_read' => true]);

        return view('chat.index', compact('customer'));
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required|string']);

        $message = Message::create([
            'user_id' => auth()->id(),
            'sender_id' => auth()->id(),
            'content' => $request->content,
            'is_read' => false,
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
