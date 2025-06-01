

@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pending Payments</h2>
    <livewire:admin-payment-alerts />
    
    @if($payments->isEmpty())
        <div class="alert alert-info">No payments found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Pay Slip</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->customer->name }}</td>
                        <td>{{ $payment->course->title }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $payment->pay_slip) }}" target="_blank">
                                View Slip
                            </a>
                        </td>
                        <td>
                            <span class="badge 
                                @if($payment->payment_status == 'pending') bg-warning
                                @elseif($payment->payment_status == 'completed') bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </td>
                        <td>
                            @if($payment->payment_status === 'pending')
                                <button class="btn btn-success btn-sm" wire:click="approvePayment({{ $payment->id }})">
                                    Approve
                                </button>
                            @else
                                <em>N/A</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    Livewire.on('paymentApproved', (paymentId) => {
        Swal.fire(
            'Approved!',
            'Payment has been approved.',
            'success'
        ).then(() => {
            location.reload();
        });
    });
</script>
@endsection
