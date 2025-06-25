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

        {{-- create --}}
        <!-- Vertically centered scrollable modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center text-primary" id="uploadModalLabel">បញ្ចូលមុខវិជ្ជាថ្មីៗ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="user" class="form-label">ឈ្មោះអ្ន​កបញ្ចូល:</label>
                                <select name="user_id" class="form-control" required>
                                    @foreach ($user as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="course_name" class="form-label">ឈ្មោះមុខវិជ្ជា:</label>
                                <input type="text" name="course_name" id="course_name" class="form-control"
                                    value="{{ old('course_name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="course_name" class="form-label">បញ្ចូលរូបភាព:</label>
                                <input type="file" class="form-control" name="imgCourse" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">ពិពណ៌នា:</label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                                {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">តម្លៃដាក់លក់($):</label>
                                <input type="number" name="price" id="price" class="form-control"
                                    value="{{ old('price') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="price_normal" class="form-label">តម្លៃដើម($):</label>
                                <input type="number" name="price_normal" id="price_normal" class="form-control"
                                    value="{{ old('price_normal') }}" required>
                            </div>

                            <div class="text-center "><button class="btn btn-primary" type="submit"><i
                                        class="fa-solid fa-floppy-disk"></i> រក្សាទុក</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- create end --}}

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <!-- Create button (left side) -->
                <a href="{{ route('course.create') }}" class="btn btn-success me-2" data-bs-toggle="modal"
                    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>

                <!-- Centered title -->
                <h5 class="mb-0 text-primary text-center flex-grow-1">មុខវិជ្ជា</h5>

                <!-- Search form aligned right -->
                <form action="{{ route('course.index') }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control form-control-md me-2"
                        placeholder="ស្វែងរកមុខវិជ្ជា..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-search"></i></button>
                </form>

            </div>
        </div>

        <!-- Courses Table -->
        <div class="card mt-4 mb-5">
            <div class="card-body ">
                @if ($course->count())
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>អ្នកបង្កើត</th>
                                <th>មុខវិជ្ជា</th>
                                <th>ពិពណ៌នា</th>
                                <th>តម្លៃដាក់លក់</th>
                                <th>តម្លៃដើម</th>
                                <th>រូបភាព</th>
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course as $index => $courses)
                                <tr>
                                    <td>{{ $i + $index + 1 }}</td>
                                    <td>{{ $user->find($courses->user_id)->name ?? 'N/A' }}</td>
                                    <td>{{ $courses->course_name }}</td>
                                    <td>{{ Str::limit($courses->description, 50) }}</td>
                                    <td>${{ number_format($courses->price, 2) }}</td>
                                    <td>${{ number_format($courses->price_normal, 2) }}</td>
                                    <td>
                                        @if ($courses->imgCourse)
                                            <img src="{{ asset('storage/' . $courses->imgCourse) }}" width="80"
                                                alt="Course Image">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('course.show', $courses->id) }}" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#showModal{{ $courses->id}}"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('course.edit', $courses->id) }}" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#updateModal{{ $courses->id}}"><i class="fa-solid fa-pen"></i></a>
                                        <form action="{{ route('course.destroy', $courses->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-deleted"
                                                data-id="{{ $courses->id }}" data-name="{{ $courses->course_name }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- update --}} {{-- update --}}
                    <!-- Vertically centered scrollable modal -->
                    <div class="modal fade" id="updateModal{{ $courses->id}}" tabindex="-1" aria-labelledby="uploadModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center text-primary" id="uploadModalLabel">
                                        កែប្រែមុខវិជ្ជា</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('course.update', $courses->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="user" class="form-label">ឈ្មោះអ្នកប្រើ:</label>
                                            <select name="user_id" class="form-control" required>
                                                @foreach ($user as $users)
                                                    <option value="{{ $users->id }}"
                                                        {{ $courses->user_id == $users->id ? 'selected' : '' }}>
                                                        {{ $users->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="course_name" class="form-label">ឈ្មោះមុខវិជ្ជា:</label>
                                            <input type="text" name="course_name" id="course_name"
                                                class="form-control" value="{{ $courses->course_name }}" required>
                                        </div>
                                        <div class="mb-3">

                                            <label for="imgCourse">រូបភាព(optional):</label>
                                            @if ($courses->imgCourse)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $courses->imgCourse) }}"
                                                        alt="Current QR Code" style="max-width: 150px;">
                                                </div>
                                            @endif
                                            <input type="file" name="imgCourse" class="form-control" id="imgCourse"
                                                accept="image/*">
                                            
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">ពិពណ៌នា:</label>
                                            <textarea name="description" id="description" class="form-control" required>{{ $courses->description }}</textarea>
                                            {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">តម្លៃដាក់លក់($):</label>
                                            <input type="number" name="price" id="price" class="form-control"
                                                value="{{ $courses->price }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="price_normal" class="form-label">តម្លៃដើម($):</label>
                                            <input type="number" name="price_normal" id="price_normal"
                                                class="form-control" value="{{ $courses->price_normal }}" required>
                                        </div>


                                        <div class="text-center "><button class="btn btn-primary" type="submit">
                                                   <i class="fa-solid fa-pen"></i> កែប្រែ</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                {{-- update end --}}
                {{-- show --}}
                <!-- Vertically centered scrollable modal -->
                <div class="modal fade" id="showModal{{ $courses->id}}" tabindex="-1" aria-labelledby="uploadModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center text-primary" id="uploadModalLabel">បង្ហាញអំពីមុខវិជ្ជា
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">



                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        @if ($courses->imgCourse)
                                            <img src="{{ asset('storage/' . $courses->imgCourse) }}"
                                                class="img-fluid w-100 rounded-start" alt="{{ $courses->course_name }}">
                                        @else
                                            <p>No course image available.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $courses->course_name }}</h5>
                                            <p class="card-text"><strong>ពិពណ៌នា:</strong> {{ $courses->description }}
                                            </p>
                                            <p class="card-text"><strong>តម្លៃដាក់លក់:</strong>
                                                ${{ number_format($courses->price, 2) }}
                                            </p>
                                            <p class="card-text"><strong>តម្លៃដើម:</strong>
                                                ${{ number_format($courses->price_normal, 2) }}</p>
                                            <p class="card-text"><strong>បញ្ចូលដោយ:</strong>
                                                {{ $courses->user->name }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($course->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $course->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($course->links()->elements[0] as $page => $url)
                                @if ($page == $course->currentPage())
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
                            @if ($course->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $course->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
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
                    <div class="alert alert-warning">មុខវិជ្ជាមិនមានទេ។</div>
                @endif
            </div>
        </div>
    </div>
    {{-- show end --}}

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
                            deleteForm.action = `{{ url('course/${sliderId}') }}`;
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
