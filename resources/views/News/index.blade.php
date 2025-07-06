@extends('layouts.master')
@section('content')
    <div class="col-md-12 home-content pb-3">
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
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Create button (left side) -->
                <a href="{{ route('news.create') }}" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>

                <!-- Centered title -->
                <h5 class="mb-0 text-primary flex-grow-1 text-center">ព័ត៌មានថ្មីៗ</h5>

                <!-- Optional placeholder to balance layout -->
                <div style="width: 100px;"></div>
            </div>
        </div>

        <div class="card p-5 mt-4">

            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="uploadModalLabel">បញ្ចូលព័ត៌មានថ្មីៗ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="image">រូបភាព</label>
                                    <input type="file" class="form-control" name="imageNews" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status">ស្ថានភាព </label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="">-- សូមជ្រើសរើសស្ថានភាព --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> រក្សាទុក</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- edit --}}
        @if ($news->count())
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>រូបភាព</th>
                    <th>ស្ថានភាព</th>
                    <th>សកម្មភាព</th>
                </thead>
                <tbody>
                    @foreach ($news as $index=> $new)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td><img src="{{ Storage::url($new->imageNews) }}" alt="" width="50px" height="50px">
                            </td>
                            <td><span
                                    class="p-2 badge {{ $new->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($new->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('news.show', $new->id) }}" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#showModel{{$new->id}}"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('news.edit', $new->id) }}" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#updateModel{{$new->id}}"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('news.destroy', $new->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-deleted" data-id="{{ $new->id }}"
                                        data-name="{{ $new->imageNews }}"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="updateModel{{$new->id}}" tabindex="-1" aria-labelledby="uploadModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">កែប្រែព័ត៌មានថ្មីៗ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('news.update', $new->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">

                                                <label for="imgCourse">រូបភាព:</label>
                                                @if ($new->imageNews)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $new->imageNews) }}"
                                                            alt="Current QR Code" style="max-width: 150px;">
                                                    </div>
                                                @endif
                                                <input type="file" name="imageNews" class="form-control" id="imgCourse"
                                                    accept="image/*">
                                                {{-- <small class="text-muted">Leave blank if you don't want to change the QR code.</small> --}}
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">ស្ថានភាព</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="">-- សូមជ្រើសរើសស្ថានភាព --</option>
                                                    <option value="active"
                                                        {{ $new->status == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="pending"
                                                        {{ $new->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                </select>
                                            </div>

                                            <div class="mb-3 text-center"><button type="submit"
                                                    class="btn btn-primary"><i class="fa-solid fa-pen"></i>
                                                    កែប្រែ</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="showModel{{$new->id}}" tabindex="-1" aria-labelledby="uploadModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel">មើលរូបព័ត៌មានថ្មីៗ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">


                                        <img src="{{ Storage::url($new->imageNews) }}" class="img-fluid w-100 mt-3"
                                            alt="Slider Image" id="sliderImage">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
         @else
            <div class="alert alert-warning">មិនមានទិន្នន័យទេ។</div>
        @endif
<!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($news->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $news->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($news->links()->elements[0] as $page => $url)
                                @if ($page == $news->currentPage())
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
                            @if ($news->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $news->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
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
                        title: 'តើអ្នកប្រាកដជាចង់លុបមែនឬទេ?',
                        text: `លុប ${sliderImage}.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'ចាស/បាទ,លុប!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with deletion
                            const deleteForm = document.createElement('form');
                            deleteForm.action = `{{ url('news/${sliderId}') }}`;
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
@endsection
