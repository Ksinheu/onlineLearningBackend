@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Payment</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('payment.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Customer -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}" {{ $payment->customer_id == $cust->id ? 'selected' : '' }}>
                        {{ $cust->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Course -->
        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" class="form-control" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $payment->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->course_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Current Pay Slip -->
        <div class="mb-3">
            <label class="form-label">Current Pay Slip</label><br>
            <img src="{{ asset('storage/' . $payment->pay_slip) }}" width="120" class="rounded border">
        </div>

        <!-- New Pay Slip Upload -->
        <div class="mb-3">
            <label for="pay_slip" class="form-label">Upload New Pay Slip (optional)</label>
            <input type="file" name="pay_slip" class="form-control">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" class="form-control">
                <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $payment->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ $payment->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <div class="text-end">
            <a href="{{ route('payment.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Update Payment</button>
        </div>
    </form>
</div>
@endsection
