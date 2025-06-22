<?php
namespace App\Events;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class NewMessageEvent implements ShouldBroadcastNow
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
         \Log::info('🔥 Broadcasting message:', [$message->toArray()]);
    }

   public function broadcastOn()
    {
        return new Channel('chat-room');
    }

    public function broadcastAs()
    {
        return 'new-message';
    }


    public function broadcastWith()
    {
        return [
            'sender' => $this->message->sender_name,
            'message' => $this->message->message,
            'time'   => $this->message->created_at->format('H:i d/m/Y'),
        ];
    }
}
