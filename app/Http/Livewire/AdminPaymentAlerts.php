<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class AdminPaymentAlerts extends Component
{
    // public function render()
    // {
    //     return view('livewire.admin-payment-alerts');
    // }
    public $newPayments = [];

    protected $listeners = ['paymentSubmitted' => 'refreshPayments'];

    public function mount()
    {
        $this->refreshPayments();
    }

    public function refreshPayments()
    {
        $this->newPayments = Purchase::with('customer', 'course')
            ->where('payment_status', 'pending')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin-payment-alerts');
    }
}
