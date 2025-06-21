@extends('layouts.master')
@section('content')
    <div class="col-12 home-content">
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

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Create button (left side) -->
                <a href="{{ route('payment_method.create') }}" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>

                <!-- Centered title -->
                <h5 class="mb-0 text-primary flex-grow-1 text-center">Payment Method</h5>

                <!-- Optional placeholder to balance layout -->
                <div style="width: 100px;"></div>
            </div>
        </div>
        <div class="card mt-4 p-5">

            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="uploadModalLabel">បញ្ចូល Payment Method</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('payment_method.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name_bank">ឈ្មោះធនាគា:</label>
                                    <input type="text" name="name_bank" class="form-control" id="name_bank" required>
                                </div>
                               


                                <div class="mb-3">
                                    <label for="number_bank">លេខកុងធនាគា:</label>
                                    <input type="number" name="number_bank" class="form-control" id="number_bank" required>
                                </div>

                                <div class="mb-3">
                                    <label for="QR_code">QR Code:</label>
                                    <input type="file" name="QR_code" class="form-control" id="QR_code"
                                        accept="image/*" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_number">លេខទូរស័ព្ទ:</label>
                                    <input type="text" name="phone_number" class="form-control" id="phone_number"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="status">ស្ថានភាព:</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">-- សូមជ្រើសរើសស្ថានភាព --</option>
                                        <option value="pending">Pending</option>
                                        <option value="active">Active</option>
                                    </select>
                                </div>

                                <div class="text-center"><button type="submit" class="btn btn-success"><i
                                            class="fa-solid fa-floppy-disk"></i> រក្យាទុក</button></div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {{-- edit --}}

            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>ឈ្មោះធនាគា</th>
                    <th>លេខធនាគា</th>
                    <th>QR-Code</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>ស្ថានភាព</th>
                    <th>សកម្មភាព</th>
                </thead>
                <tbody>
                    @foreach ($payment_method as $payment_methods)
                        <tr>
                            <td>{{ $payment_methods->id }}</td>
                            <td>{{ $payment_methods->name_bank }}</td>
                            <td>{{ $payment_methods->number_bank }}</td>
                            <td><img src="{{ Storage::url($payment_methods->QR_code) }}" alt="" width="50px"
                                    height="50px"></td>
                            <td>{{ $payment_methods->phone_number }}</td>
                            <td><span class="badge {{ $payment_methods->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($payment_methods->status) }}</span></td>
                            <td>
                                <a href="{{ route('payment_method.show', $payment_methods->id) }}" class="btn btn-warning"
                                    data-bs-toggle="modal" data-bs-target="#showModel{{ $payment_methods->id }}"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('payment_method.edit', $payment_methods->id) }}" class="btn btn-info"
                                    data-bs-toggle="modal" data-bs-target="#updateModel{{ $payment_methods->id }}"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('payment_method.destroy', $payment_methods->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-deleted"
                                        data-id="{{ $payment_methods->id }}"
                                        data-name="{{ $payment_methods->name_bank }}"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="updateModel{{ $payment_methods->id }}" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">កែប្រែប្រភេទធនាគា</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
            
                                        <form action="{{ route('payment_method.update', $payment_methods->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name_bank">ឈ្មោះធនាគា:</label>
                                                <input type="text" name="name_bank" class="form-control" id="name_bank"
                                                    value="{{ old('name_bank', $payment_methods->name_bank) }}" required>
                                            </div>
            
                                            <div class="mb-3">
                                                <label for="number_bank">លេខកុងធនាគា:</label>
                                                <input type="number" name="number_bank" class="form-control" id="number_bank"
                                                    value="{{ old('number_bank', $payment_methods->number_bank) }}" required>
                                            </div>
            
                                            <div class="mb-3">
                                                <label for="QR_code">QR Code:</label>
                                                @if ($payment_methods->QR_code)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $payment_methods->QR_code) }}"
                                                            alt="Current QR Code" style="max-width: 150px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="QR_code" class="form-control" id="QR_code"
                                                    accept="image/*">
                                                <small class="text-muted">Leave blank if you don't want to change the QR code.</small>
                                            </div>
            
                                            <div class="mb-3">
                                                <label for="phone_number">លេខទូរស័ព្ទ:</label>
                                                <input type="text" name="phone_number" class="form-control" id="phone_number"
                                                    value="{{ old('phone_number', $payment_methods->phone_number) }}" required>
                                            </div>
            
                                            <div class="mb-3">
                                                <label for="status">ស្ថានភាព:</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">-- សូមជ្រើសរើសស្ថានភាព --</option>
                                                    <option value="pending"
                                                        {{ $payment_methods->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="active"
                                                        {{ $payment_methods->status === 'active' ? 'selected' : '' }}>Active</option>
                                                </select>
                                            </div>
            
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i>
                                                    កែប្រែ</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="modal fade" id="showModel{{ $payment_methods->id }}" tabindex="-1" aria-labelledby="uploadModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">Payment Method Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
            
                                        <div class="mb-3">
                                            <label for="" class="form-lable">ឈ្មោះធនាគារ</label>
                                            <input type="text" readonly name="" class="form-control"
                                                value="{{ $payment_methods->name_bank }}" id="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-lable">លេខកុងធនាគា</label>
                                            <input type="text" readonly name="" class="form-control"
                                                value="{{ $payment_methods->number_bank }}" id="">
                                        </div>
            
                                        <div class="mb-3">
                                            <label for="" class="form-lable">លេខទូរស័ព្ទ</label>
                                            <input type="text" readonly name="" class="form-control"
                                                value="{{ $payment_methods->phone_number }}" id="">
                                        </div>
                                        <p><strong>QR Code:</strong></p>
                                        @if ($payment_methods->QR_code)
                                            <img src="{{ asset('storage/' . $payment_methods->QR_code) }}" alt="QR Code"
                                                width="200">
                                        @else
                                            <p>No QR code uploaded.</p>
                                        @endif
            
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
           <!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($payment_method->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $payment_method->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($payment_method->links()->elements[0] as $page => $url)
                                @if ($page == $payment_method->currentPage())
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
                            @if ($payment_method->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $payment_method->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="next">»</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link bg-light text-muted">»</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
               
        </div>
        
    </div>
    
    <script>
        // SweetAlert delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-deleted');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sliderId = this.getAttribute('data-id');
                    const sliderImage = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete ${sliderImage}. This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with deletion
                            const deleteForm = document.createElement('form');
                            deleteForm.action = `{{ url('payment_method/${sliderId}') }}`;
                            deleteForm.method = 'POST';
                            deleteForm.innerHTML = `@csrf @method('DELETE')`;
                            document.body.appendChild(deleteForm);
                            deleteForm.submit();
                        }
                    });
                });
            });
        })
    </script>
    </div>
@endsection
