@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-8 home-content mb-4">
        <div class="card p-5">
            <div class="text-center fs-4 text-primary">Update Payment Method</div>
            <form action="{{ route('payment_method.update', $payment_method->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <div class="mb-3">
                    <label for="name_bank">ឈ្មោះធនាគា:</label>
                    <input type="text" name="name_bank" class="form-control" id="name_bank" value="{{ old('name_bank', $payment_method->name_bank) }}" required>
                </div>
            
                <div class="mb-3">
                    <label for="number_bank">លេខកុងធនាគា:</label>
                    <input type="number" name="number_bank" class="form-control" id="number_bank" value="{{ old('number_bank', $payment_method->number_bank) }}" required>
                </div>
            
                <div class="mb-3">
                    <label for="QR_code">QR Code:</label>
                    @if ($payment_method->QR_code)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $payment_method->QR_code) }}" alt="Current QR Code" style="max-width: 150px;">
                        </div>
                    @endif
                    <input type="file" name="QR_code" class="form-control" id="QR_code" accept="image/*">
                    <small class="text-muted">Leave blank if you don't want to change the QR code.</small>
                </div>
            
                <div class="mb-3">
                    <label for="phone_number">លេខទូរស័ព្ទ:</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $payment_method->phone_number) }}" required>
                </div>
            
                <div class="mb-3">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ $payment_method->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ $payment_method->status === 'active' ? 'selected' : '' }}>Active</option>
                    </select>
                </div>
            
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Payment Method</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection