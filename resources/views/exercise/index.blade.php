@extends('layouts.master')
@section('content')
    <div class="col-md-12 pb-3 home-content">
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
        <div class="card p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('exercise.create') }}" class="btn btn-success me-2 " data-bs-toggle="modal"
                    data-bs-target="#uploadModal">
                    <i class="fa-solid fa-plus"></i> បង្កើត
                </a>
                <h5 class="mb-0 text-primary text-center flex-grow-1">លំហាត់</h5>
            </div>
        </div>

        {{-- create --}}
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="uploadModalLabel">បញ្ចូលលំហាត់</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exercise.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Course Selection --}}
                            <div class="mb-3">
                                <label for="lesson" class="form-label">lesson:</label>
                                <select name="lesson_id" class="form-control" required>
                                    <option value="" disabled selected>Select a lesson</option>
                                    @foreach ($lesson as $lessons)
                                        <option value="{{ $lessons->id }}"
                                            {{ old('lesson_id') == $lessons->id ? 'selected' : '' }}>
                                            {{ $lessons->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Lesson Title --}}
                            <div class="mb-3">
                                <label for="exercise_element" class="form-label">Exercise Element</label>
                                <textarea name="exercise_element" class="form-control" rows="3" required></textarea>
                            </div>

                            {{-- Lesson Content --}}
                            <div class="mb-3">
                                <label for="images" class="form-label">Upload Images (multiple allowed)</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>





                            {{-- Submit Button --}}
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">រក្សាទុក</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- create end --}}

        <!-- Exercises Table -->
        <div class="card">
            <div class="card-body">
                @if ($exercise->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>មេរៀន</th>
                                <th>លំហាត់</th>
                                <th>រូបភាព</th>
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exercise as $index => $ex)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ex->lesson->title ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($ex->exercise_element, 50) }}</td>
                                    <td>
                                        @foreach ($ex->exerciseImage as $img)
                                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image"
                                                width="50" height="50" class="me-1 mb-1">
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('exercise.edit', $ex->id) }}" class="btn btn-info"
                                            data-bs-toggle="modal" data-bs-target="#updateModal{{$ex->id}}">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form id="delete-form-{{ $ex->id }}"
                                            action="{{ route('exercise.destroy', $ex->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-delete-confirm"
                                                data-id="{{ $ex->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- update --}}
                                <div class="modal fade" id="updateModal{{$ex->id}}" tabindex="-1" aria-labelledby="uploadModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="uploadModalLabel">កែប្រែលំហាត់</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('exercise.update', $ex->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Lesson ID -->
                                                    <div class="mb-3">
                                                        <label for="lesson_id" class="form-label">Lesson</label>
                                                        <select name="lesson_id" id="lesson_id" class="form-control">
                                                            @foreach ($lesson as $lessions)
                                                                <option value="{{ $lessions->id }}"
                                                                    {{ $lessions->id == $ex->lesson_id ? 'selected' : '' }}>
                                                                    {{ $lessions->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('lesson_id')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Exercise Element -->
                                                    <div class="mb-3">
                                                        <label for="exercise_element" class="form-label">Exercise
                                                            Element</label>
                                                        <input type="text" name="exercise_element"
                                                            id="exercise_element" class="form-control"
                                                            value="{{ old('exercise_element', $ex->exercise_element) }}">
                                                        @error('exercise_element')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Existing Images -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Images:</label><br>
                                                        @foreach ($ex->exerciseImage as $img)
                                                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                                                alt="Exercise Image" width="100" class="me-2 mb-2">
                                                        @endforeach
                                                    </div>

                                                    <!-- Upload New Images -->
                                                    <div class="mb-3">
                                                        <label for="images" class="form-label">Add More Images</label>
                                                        <input type="file" name="images[]" multiple
                                                            class="form-control">
                                                        @error('images.*')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i> កែប្រែ</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- create end --}}
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($exercise->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $exercise->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($exercise->links()->elements[0] as $page => $url)
                                @if ($page == $exercise->currentPage())
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
                            @if ($exercise->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $exercise->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
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
                    <div class="alert alert-warning">គ្មានលំហាត់ទេ។</div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-confirm');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${itemId}`).submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
