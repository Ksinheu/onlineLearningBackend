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

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0 text-primary text-center flex-grow-1">មតិយោបល់សិស្ស</h5>
            </div>
        </div>

        <div class="card mt-4 mb-5">
            <div class="card-body ">
                @if ($comments->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>វគ្គសិក្សា</th>
                                <th>អតិថិជន</th>
                                <th>មតិយោបល់</th>
                                <th>កាលបរិច្ឆេទ</th>
                                {{-- <th>ស្ថានភាព</th> --}}
                                <th>សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $index => $comment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $comment->course->course_name ?? 'N/A' }}</td>
                                    <td>{{ $comment->customer->username ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($comment->comment, 50) }}</td>

                                    <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                    {{-- <td>
                                        @if ($comment->read_status == 'pending')
                                            <span class="badge text-primary p-2">ថ្មី</span>
                                        @else
                                            <span class="badge bg-success p-2">Active</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <form id="delete-form-{{ $comment->id }}"
                                            action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                            style="display:inline-block; align:center">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)"
                                                class=" btn-deleted text-danger"
                                                data-id="{{ $comment->id }}" data-name="{{ $comment->id }}"
                                                title="លុបមតិ">
                                                <i class="fa-solid fa-trash me-1"></i>
                                            </a>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $comments->links() }} --}}
                @else
                    <div class="alert alert-warning">មិនទាន់មានមតិយោបល់។</div>
                @endif
            </div>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-deleted');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
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
                        form.action = `/comments/${id}`;
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
