<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPaymentNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customerName;
    public $paymentId;

    public function __construct($customerName, $paymentId)
    {
        $this->customerName = $customerName;
        $this->paymentId = $paymentId;
    }

    public function broadcastOn()
    {
        return new Channel('payment-notifications');
    }

    public function broadcastAs()
    {
        return 'newPayment';
    }
}
