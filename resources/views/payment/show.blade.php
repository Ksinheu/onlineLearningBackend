@extends('layouts.master')

@section('content')
<div class="home-content">
    <div class="card p-4 shadow-sm">
        <h5 class="text-primary text-center mb-4">ព័ត៌មានការទូទាត់របស់សិស្ស</h5>

        <div class="row">
            <div class="col-md-6">
                <p><strong>អ្នកជាវ (Customer):</strong> {{ $payment->customer->username ?? 'N/A' }}</p>
                <p><strong>មុខវិជ្ជា (Course):</strong> {{ $payment->course->course_name ?? 'N/A' }}</p>
                <p><strong>កាលបរិច្ឆេទបង់ប្រាក់:</strong> {{ \Carbon\Carbon::parse($payment->purchase_date)->format('d-m-Y') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>ស្ថានភាពបង់ប្រាក់:</strong>
                    @if($payment->payment_status === 'completed')
                        <span class="badge bg-success p-2 fs-6">បានបង់</span>
                    @else
                        <span class="badge bg-danger p-2 fs-6">មិនទាន់បង់</span>
                    @endif
                </p>
                <p><strong>Pay Slip:</strong></p>
                @if($payment->pay_slip)
                    <img src="{{ asset('storage/' . $payment->pay_slip) }}" alt="Pay Slip" class="img-fluid rounded" width="250">
                @else
                    <p>No pay slip available.</p>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('payment.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>
    </div>
</div>
@endsection
