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

        <!-- Header -->
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('lession.create') }}" class="btn btn-success me-2" data-bs-toggle="modal"
                    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i>
                    បង្កើត</a>
                <h5 class="mb-0 text-primary text-center flex-grow-1">មេរៀន</h5>
                <form action="{{ route('lession.index') }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control form-control-md me-2"
                        placeholder="ស្វែងរកមេរៀន..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
        {{-- create --}}
        <!-- Vertically centered scrollable modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center text-primary" id="uploadModalLabel">បញ្ចូលមេរៀនថ្មី</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('lession.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Course Selection -->
                            <div class="mb-3">
                                <label for="course_id" class="form-label">ជ្រើសរើសមុខវិជ្ជា:</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
                                    @foreach ($course as $c)
                                        <option value="{{ $c->id }}"
                                            {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                            {{ $c->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lesson Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">ចំណងជើង:</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ old('title') }}" required>
                            </div>
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> រក្សាទុក
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- create end --}}
        <!-- Lessons Table -->
        <div class="card mt-4 mb-5">
            <div class="card-body">
                @if ($lession->count())
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ចំណងជើង</th>
                                <th>មុខវិជ្ជា</th>
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lession as $index => $lesson)
                                <tr>
                                    <td>{{ $i + $index + 1 }}</td>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ $course->find($lesson->course_id)->course_name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('lession.show', $lesson->id) }}" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#showModal{{ $lesson->id }}"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('lession.edit', $lesson->id) }}" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#updateModal{{ $lesson->id }}"><i
                                                class="fa-solid fa-pen"></i></a>
                                        <form action="{{ route('lession.destroy', $lesson->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-deleted"
                                                data-id="{{ $lesson->id }}" data-name="{{ $lesson->title }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- update --}}
                                <!-- Vertically centered scrollable modal -->
                                <div class="modal fade" id="updateModal{{ $lesson->id }}" tabindex="-1"
                                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center text-primary" id="uploadModalLabel">
                                                    កែប្រែមេរៀន</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('lession.update', $lesson->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    {{-- Course Selection --}}
                                                    <div class="mb-3">
                                                        <label for="course" class="form-label">មុខវិជ្ជា:</label>
                                                        <select name="course_id" class="form-control" required>
                                                            <option value="" disabled selected>ជ្រើសរើសមុខវិជ្ជា
                                                            </option>
                                                        
                                                            @foreach ($course as $courses)
                                                                <option value="{{ $courses->id }}"
                                                                    {{ $courses->id == $lesson->course_id ? 'selected' : '' }}>
                                                                    {{ $courses->course_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Lesson Title --}}
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">ចំណងជើង:</label>
                                                        <input type="text" name="title" id="title"
                                                            class="form-control" value="{{ $lesson->title }}" required>
                                                    </div>

                                                    {{-- Submit Button --}}
                                                    <div class="text-center">
                                                        <button class="btn btn-primary" type="submit"><i
                                                                class="fa-solid fa-pen"></i> កែប្រែ</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- update end --}}
                                {{-- show --}}
                                <!-- Vertically centered scrollable modal -->
                                <div class="modal fade" id="showModal{{ $lesson->id }}" tabindex="-1"
                                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center text-primary" id="uploadModalLabel">
                                                    មើលមេរៀន</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h1>{{ $lesson->title }}</h1>
                                                <p><strong>Course:</strong>
                                                    {{ $course->find($lesson->course_id)->course_name ?? 'N/A' }}</p>
                                                {{-- <p><strong>Content:</strong> {{ $lesson->content }}</p> --}}
                                                <h3>Video</h3>
                                                <video controls>
                                                    <source src="{{ asset('storage/' . $lesson->video_url) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- update end --}}
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav class="position-relative border-0 shadow-none justify-content-end">
                        <ul class="pagination">
                            @if ($lession->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $lession->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            @foreach ($lession->links()->elements[0] as $page => $url)
                                @if ($page == $lession->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link bg-light text-dark"
                                            href="{{ $url }}{{ request()->has('search') ? '&search=' . request('search') : '' }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            @if ($lession->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $lession->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
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
                    <div class="alert alert-warning">មេរៀនមិនមានទេ។</div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-deleted');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lessonId = this.getAttribute('data-id');
                    const lessonTitle = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete "${lessonTitle}". This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const deleteForm = document.createElement('form');
                            deleteForm.action = `{{ url('lession/${lessonId}') }}`;
                            deleteForm.method = 'POST';
                            deleteForm.innerHTML = `@csrf @method('DELETE')`;
                            document.body.appendChild(deleteForm);
                            deleteForm.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
