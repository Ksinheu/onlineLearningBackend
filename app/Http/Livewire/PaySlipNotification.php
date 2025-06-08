<?php

namespace App\Http\Livewire;

use App\Models\Purchase;
use Livewire\Component;

class PaySlipNotification extends Component
{
    public $message = '';

    protected $listeners = ['echo:pay-slip,PaySlipUploaded' => 'notifyUpload'];

    public function notifyUpload($payload)
    {
        $this->message = 'Payment slip uploaded successfully for course ID: ' . $payload['purchase']['course_id'];

        // Auto-clear after 5 seconds
        $this->dispatchBrowserEvent('clear-notification');
    }
    public function render()
    {
        // BAD: Loading huge data
   $payments = Purchase::with('customer', 'course')
                    ->latest()
                    ->paginate(5); // ✅ USE PAGINATION

        return view('livewire.pay-slip-notification', [
            'payments' => $payments,
        ]);
    
    }
}
