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
                        <label for="user" class="form-label">User:</label>
                        <select name="user_id" class="form-control" required>
                            @foreach ($user as $users)
                                <option value="{{ $users->id }}">{{ $users->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Name:</label>
                        <input type="text" name="course_name" id="course_name" class="form-control"
                            value="{{ old('course_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_name" class="form-label">Upload Image:</label>
                        <input type="file" class="form-control" name="imgCourse" required>   
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                        {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price($):</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
                    <div class="text-center "><button class="btn btn-primary" type="submit">រក្សាទុក</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- create end --}}
<div class="text-center fs-4 text-primary text-decoration-underline">បញ្ជីឈ្មោះមុខវិជ្ជា</div>
<div class="mb-3 ms-3">
    <a href="{{route('course.create')}}" class="btn btn-success" data-bs-toggle="modal"
    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>
</div>
        <div class="overview-boxes">
            <table class="table table-hover">
              <thead>
                <th>ID</th>
                <th>User</th>
                <th>Course Name</th>
                <th>Course Image</th>
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
                    <td><img src="{{ Storage::url($courses->imgCourse) }}" alt="" width="50px" height="50px"></td>
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