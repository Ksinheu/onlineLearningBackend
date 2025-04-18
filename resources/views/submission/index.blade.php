@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <div class="card p-5">
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
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            <div class="text-center fs-5 text-primary text-decoration-underline">បញ្ជីឈ្មោះមុខវិជ្ជា</div>
            <div class="mb-3">
                <a href="{{route('course.create')}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> បង្កើត</a>
            </div>
            <table class="table table-hover">
              <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Title</th>
                <th>submission_date</th>
                <th>grade</th>
                <th>feedback</th>
                <th>option</th>
              </thead>
              <tbody>
                @foreach($submission as $submissions)
                <tr>
                    <td>{{$submissions->id}}</td>
                    <td>{{$submissions->user->name}}</td>
                    <td>{{$submissions->assignment->title}}</td>
                    <td>{{$submissions->submission_date}}</td>
                    <td>{{$submissions->grade}}</td>
                    <td>{{$submissions->feedback}}</td>
                    <td>
                      <a href="{{route('submission.show',$submissions->id)}}" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                      <a href="{{route('submission.edit',$submissions->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                      <form action="{{ route('submission.destroy', $submissions->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-deleted" data-id="{{$submissions->id}}" data-name="{{$submissions->submission_date}}"><i class="fa-solid fa-trash"></i></button>
                    </form>
                     </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
    </div>
    <script>
        // SweetAlert delete confirmation
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-deleted');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
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
                            deleteForm.action = `{{ url('submission/${sliderId}') }}`;
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
