<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class AdminPaymentAlerts extends Component
{
    public $newPayments = [];

    protected $listeners = ['paymentSubmitted' => 'refreshPayments'];

    public function mount()
    {
        $this->refreshPayments();
    }

    public function refreshPayments()
    {
        $latestPayments = Purchase::with('customer', 'course')
        ->where('payment_status', 'pending')
        ->latest()
        ->take(5)
        ->get();

    // Check if there's a new payment compared to previous list
    if ($latestPayments->count() > count($this->newPayments)) {
        // Get the first new payment
        $new = $latestPayments->first();
        $this->dispatchBrowserEvent('new-payment-alert', [
            'customer' => $new->customer->name ?? 'Unknown Customer',
            'course' => $new->course->title ?? 'Unknown Course'
        ]);
    }

    $this->newPayments = $latestPayments;
    }

    public function render()
    {
        return view('livewire.admin-payment-alerts');
    }
}
