<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class PaymentNotification extends Component
{
    public $notifications = [];
    public $showNotification = false;

    protected $listeners = ['newPayment' => '$refresh'];

    public function mount()
    {
        $this->notifications = Cache::get('payment_notifications', []);
    }

    public function render()
    {
        return view('livewire.payment-notification');
    }

    public function markAsRead($key)
    {
        $notifications = Cache::get('payment_notifications', []);
        if (isset($notifications[$key])) {
            unset($notifications[$key]);
            Cache::put('payment_notifications', $notifications);
        }
    }

    public function markAllAsRead()
    {
        Cache::put('payment_notifications', []);
    }
}
