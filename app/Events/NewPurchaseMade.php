<?php

namespace App\Events;

use App\Models\Purchase;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPurchaseMade
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    use InteractsWithSockets, SerializesModels;

    public $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase->load('customer', 'course');
    }

    public function broadcastOn()
    {
        return new Channel('admin-payments');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->purchase->id,
            'customer' => $this->purchase->customer->username,
            'course' => $this->purchase->course->title,
            'payment_status' => $this->purchase->payment_status,
            'created_at' => $this->purchase->created_at->toDateTimeString(),
        ];
    }
  
    
}
