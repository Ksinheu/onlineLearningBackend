<?php

namespace App\Listeners;

use App\Events\PaySlipUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Livewire\Livewire;

class EmitPaySlipNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PaySlipUploaded $event)
    {
        Livewire::emit('paySlipUploaded', [
            'message' => 'New payslip uploaded by customer #' . $event->purchase->customer_id,
        ]);
    }
    
    
}
