<?php

namespace App\Listeners;

use App\Events\NewPaymentNotification;
use Illuminate\Support\Facades\Cache;

class SendPaymentNotification
{
    public function handle(NewPaymentNotification $event)
    {
        $notifications = Cache::get('payment_notifications', []);
        $notifications[] = [
            'customer' => $event->customerName,
            'time' => now()->format('Y-m-d H:i:s'),
            'payment_id' => $event->paymentId
        ];
        
        // Keep only the last 10 notifications
        if (count($notifications) > 10) {
            array_shift($notifications);
        }
        
        Cache::put('payment_notifications', $notifications);
    }
}
