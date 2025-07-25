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
                toast: true, position: 'bottom-end', title: 'Success!',
                text: '{{ session('success') }}', icon: 'success',
                showConfirmButton: false, timer: 3000, timerProgressBar: true,
            });
        </script>
    @endif

    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <a href="#" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fa-solid fa-plus"></i> បង្កើត
            </a>
            <h5 class="mb-0 text-primary text-center flex-grow-1">មាតិកា</h5>
        </div>
    </div>

    {{-- Create Modal --}}
    @include('content.partials.create')

    {{-- Table --}}
    <div class="card mt-4 mb-5">
        <div class="card-body ">
            @if ($contents->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>មុខវិជ្ជា</th>
                            <th>មេរៀន</th>
                            <th>ចំនួនម៉ោង</th>
                            <th>មាតិកា</th>
                            <th>លទ្ធផល</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $index => $content)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $content->course->course_name ?? 'N/A' }}</td>
                                <td>{{ $content->lesson->title ?? 'N/A' }}</td>
                                <td>{{ $content->session }}ម៉ោង</td>
                                <td>{{ Str::limit($content->Lesson_content, 10) }}</td>
                                <td>{{ Str::limit($content->expect_result, 10) }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#showModal{{ $content->id }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $content->id }}">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <form action="{{ route('content.destroy', $content->id) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-deleted" data-id="{{ $content->id }}" data-name="Content {{ $content->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Show & Edit Modals --}}
                            @include('content.partials.edit', ['content' => $content])
                            {{-- @include('content.partials.show', ['content' => $content]) --}}
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination with search query preserved -->
                    <nav class="position-relative border-0 shadow-none justify-content-end ">
                        <ul class="pagination ">
                            {{-- Previous Page Link --}}
                            @if ($contents->onFirstPage())
                                <li class="page-item disabled"><span class="page-link bg-light text-muted">«</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $contents->previousPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
                                        rel="prev">«</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($contents->links()->elements[0] as $page => $url)
                                @if ($page == $contents->currentPage())
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
                            @if ($contents->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link bg-light text-dark"
                                        href="{{ $contents->nextPageUrl() }}{{ request()->has('search') ? '&search=' . request('search') : '' }}"
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
                <div class="alert alert-warning">មាតិកាមិនទាន់មានទេ។</div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-deleted');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete "${name}". This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.action = `/content/${id}`;
                        form.method = 'POST';
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
