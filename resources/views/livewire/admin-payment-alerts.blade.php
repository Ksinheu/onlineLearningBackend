<div wire:poll.10s>
    @if($newPayments->isNotEmpty())
        @foreach($newPayments as $payment)
            <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $payment->customer->name }}</strong> submitted payment for 
                    <strong>{{ $payment->course->title }}</strong>.
                </div>
                <a href="{{ route('admin.payments') }}" class="btn btn-sm btn-primary">Review</a>
            </div>
        @endforeach
    @else
        <div class="alert alert-success">No new payments at the moment.</div>
    @endif
</div>

