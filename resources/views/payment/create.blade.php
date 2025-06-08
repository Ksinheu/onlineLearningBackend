@extends('layouts.master')
@section('content')
<div class="container">
    <h3>Add Payment</h3>
    <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Customer</label>
            <select name="customer_id" class="form-control" required>
                @foreach ($customers as $cust)
                    <option value="{{ $cust->id }}">{{ $cust->username }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Course</label>
            <select name="course_id" class="form-control" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pay Slip</label>
            <input type="file" name="pay_slip" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="payment_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
