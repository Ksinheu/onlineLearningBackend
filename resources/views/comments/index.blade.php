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
                            <th>ស្ថានភាព</th>
                            <th>កាលបរិច្ឆេទ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $index => $comment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $comment->course->course_name ?? 'N/A' }}</td>
                                <td>{{ $comment->customer->username ?? 'N/A' }}</td>
                                <td>{{ Str::limit($comment->comment, 50) }}</td>
                                <td>
                                    @if($comment->read_status == 'pending')
                                        <span class="badge bg-warning p-2">Pending</span>
                                    @else
                                        <span class="badge bg-success p-2">Active</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
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
