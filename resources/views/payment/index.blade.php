@extends('layouts.master')

@section('content')
<div class="home-content">
    @if ($errors->any())
        <script>
            Swal.fire({ title: 'Error!', text: 'Something went wrong.', icon: 'error', confirmButtonText: 'Retry' });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        </script>
    @endif

    {{-- Create Button & Search --}}
    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <a href="#" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createPaymentModal">
                <i class="fa fa-plus"></i> បង្កើត
            </a>
            <h5 class="mb-0 text-primary text-center flex-grow-1">ការទូទាត់</h5>
            <form action="{{ route('payment.index') }}" method="GET" class="d-flex" style="width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="ស្វែងរក..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

   
{{-- Table --}}
    <div class="card mt-4 mb-5">
        <div class="card-body">
            @if ($payments->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>អតិថិជន</th>
                            <th>មុខវិជ្ជា</th>
                            <th>Pay Slip</th>
                            <th>ថ្ងៃទិញ</th>
                            <th>ស្ថានភាព</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payment->customer->username ?? 'N/A' }}</td>
                                <td>{{ $payment->course->course_name ?? 'N/A' }}</td>
                                <td>
                                    @if ($payment->pay_slip)
                                        <img src="{{ asset('storage/' . $payment->pay_slip) }}" width="60">
                                    @else N/A
                                    @endif
                                </td>
                                <td>{{ $payment->purchase_date }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($payment->payment_status) }}</span></td>
                                <td>
                                    <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>
                                    <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-delete" data-name="payment {{ $payment->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $payments->appends(request()->query())->links() }}
                </div>
            @else
                <div class="alert alert-warning">មិនមានទិន្នន័យទេ។</div>
            @endif
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="createPaymentLabel">បញ្ចូលការទូទាត់ថ្មី</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                            <label>Payment Status</label>
                            <select name="payment_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> រក្សាទុក</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Delete --}}
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('form');
            let name = this.getAttribute('data-name');
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${name}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
