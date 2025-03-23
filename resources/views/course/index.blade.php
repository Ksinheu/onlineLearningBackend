@extends('layouts.app')
@section('content')
    <div class="col-md-12 pb-3">
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

  @if(session('success'))
  <script>
      Swal.fire({
          title: 'Success!',
          text: '{{ session('success') }}',
          icon: 'success',
          confirmButtonText: 'OK'
      });
  </script>
  @endif
        <div class="card p-5">
            <div class="text-center fs-5 text-primary text-decoration-underline">បញ្ជីឈ្មោះមុខវិជ្ជា</div>
            <div class="mb-3">
                <a href="{{route('course.create')}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> បង្កើត</a>
            </div>
            <table class="table table-hover">
              <thead>
                <th>ID</th>
                <th>User</th>
                <th>Course Name</th>
                <th>Description</th>
                <th>Price($)</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>option</th>
              </thead>
              <tbody>
                @foreach($course as $courses)
                <tr>
                    <td>{{$courses->id}}</td>
                    <td>{{$courses->user->name}}</td>
                    <td>{{$courses->course_name}}</td>
                    <td>{{$courses->description}}</td>
                    <td>{{$courses->price}}$</td>
                    <td>{{$courses->start_date}}</td>
                    <td>{{$courses->end_date}}</td>
                    <td>
                      <a href="{{route('course.show',$courses->id)}}" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                      <a href="{{route('course.edit',$courses->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                      <form action="{{ route('course.destroy', $courses->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-deleted" data-id="{{$courses->id}}" data-name="{{$courses->course_name}}"><i class="fa-solid fa-trash"></i></button>
                    </form>
                     </td>
                </tr>
                @endforeach
              </tbody>
            </table>
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