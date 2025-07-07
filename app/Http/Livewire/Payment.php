<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class Payment extends Component
{
    public $newPayments = [];
    public $lastSeenId = 0;
    public $showPopup = false;
    public $latestPayments = []; // Add this line

    public function mount()
    {
        $this->lastSeenId = session('admin_last_seen_payment_id', Purchase::max('id') ?? 0);
        $this->getPayments();
    }
      // Load latest 5 payments
    public function getPayments()
    {
        $this->latestPayments = Purchase::with('customer', 'course')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
    public function getNewPurchase()
    {
        // Get new purchases since lastSeenId
        $newPurchases = Purchase::with('customer', 'course')
            ->where('id', '>', $this->lastSeenId)
            ->orderBy('id', 'asc')
            ->get();

        // If there are new purchases
        if ($newPurchases->isNotEmpty()) {
            $this->newPayments = $newPurchases;
            $this->lastSeenId = $newPurchases->last()->id;

            // Store lastSeenId in session to persist across requests
            session(['admin_last_seen_payment_id' => $this->lastSeenId]);
           
            $this->showPopup = true;
            $this->dispatchBrowserEvent('playNotificationSound');
        }
    }

    public function closePopup()
    {
        $this->showPopup = false;
        $this->newPayments = [];
    }

    public function render()
    {
        return view('livewire.payment');
    }
}
