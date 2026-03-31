<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $customerId;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, $customerId)
    {
        $this->message = $message;
        $this->customerId = $customerId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.room.' . $this->customerId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        // Must reload the relationship if not eager-loaded
        $this->message->loadMissing('order');

        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'isAdmin' => $this->message->sender_id != $this->message->user_id,
            'time' => $this->message->created_at->format('H:i'),
            'isRead' => (bool)$this->message->is_read,
            'order' => $this->message->order ? [
                'id' => $this->message->order->id,
                'order_number' => 'ORD-' . str_pad($this->message->order->id, 4, '0', STR_PAD_LEFT),
                'total_price' => $this->message->order->total_price,
                'status' => $this->message->order->status,
            ] : null,
        ];
    }
}
