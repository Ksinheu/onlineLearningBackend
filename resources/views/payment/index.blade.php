@extends('layouts.master')

@section('content')
    <div class="home-content">
        @if ($errors->any())
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong.',
                    icon: 'error',
                    confirmButtonText: 'Retry'
                });
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
               
                <h5 class="mb-0 text-primary text-center flex-grow-1">ការទូទាត់</h5>
                <form action="{{ route('payment.index') }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control me-2" placeholder="ស្វែងរក..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>


        <div class="card mt-4 mb-5">
            <div class="card-body">
                @if ($payments->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>អតិថិជន</th>
                                <th>មុខវិជ្ជា</th>
                                <th>វិក័យបត្រទូទាត់</th>
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
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $payment->purchase_date }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($payment->payment_status) }}</span></td>
                                    <td>
                                        <a href="{{ route('payment.show', $payment->id) }}"
                                            class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updatePayment{{$payment->id}}"><i
                                                class="fa fa-pen"></i></a>
                                        <form action="{{ route('payment.destroy', $payment->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete"
                                                data-name="payment {{ $payment->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- Update Modal --}}
                                <div class="modal fade" id="updatePayment{{ $payment->id }}" tabindex="-1"
                                    aria-labelledby="createPaymentLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="createPaymentLabel">
                                                    កែប្រែការទូទាត់</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('payment.update', $payment->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Customer -->
                                                    <div class="mb-3">
                                                        <label for="customer_id" class="form-label">អតិថិជន</label>
                                                        <select name="customer_id" class="form-control" required>
                                                            @foreach ($customers as $cust)
                                                                <option value="{{ $cust->id }}"
                                                                    {{ $payment->customer_id == $cust->id ? 'selected' : '' }}>
                                                                    {{ $cust->username }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Course -->
                                                    <div class="mb-3">
                                                        <label for="course_id" class="form-label">វគ្គសិក្សា</label>
                                                        <select name="course_id" class="form-control" required>
                                                            @foreach ($courses as $course)
                                                                <option value="{{ $course->id }}"
                                                                    {{ $payment->course_id == $course->id ? 'selected' : '' }}>
                                                                    {{ $course->course_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Current Pay Slip -->
                                                    <div class="mb-3">
                                                        <label class="form-label">វិក័យបត្រទូទាត់បច្ចុប្បន្ន</label><br>
                                                        <img src="{{ asset('storage/' . $payment->pay_slip) }}"
                                                            width="120" class="rounded border">
                                                    </div>

                                                    <!-- New Pay Slip Upload -->
                                                    <div class="mb-3">
                                                        <label for="pay_slip" class="form-label">បញ្ចូលវិក័យបត្រទូទាត់
                                                            (optional)</label>
                                                        <input type="file" name="pay_slip" class="form-control">
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label for="payment_status" class="form-label">
                                                            ស្ថានភាព</label>
                                                        <select name="payment_status" class="form-control">
                                                            <option value="">-- សូមជ្រើសរើសស្ថានភាព --</option>
                                                            <option value="pending"
                                                                {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="completed"
                                                                {{ $payment->payment_status == 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                            <option value="failed"
                                                                {{ $payment->payment_status == 'failed' ? 'selected' : '' }}>
                                                                Failed</option>
                                                        </select>
                                                    </div>

                                                    <div class="text-center">
                                                        
                                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i> កែប្រែ</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($payments->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $payment->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($payments->links()->elements[0] as $page => $url)
                                @if ($page == $payments->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-light text-dark"
                                            href="{{ $url }}{{ request()->has('search') ? '&search=' . request('search') : '' }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($payments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $payments->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="next">»</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link bg-light text-muted">»</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @else
                    <div class="alert alert-warning">មិនមានទិន្នន័យទេ។</div>
                @endif
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
