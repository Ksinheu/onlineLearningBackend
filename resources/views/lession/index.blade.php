@extends('layouts.master')
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
<div class="text-center fs-5 text-primary text-decoration-underline">មេរៀន</div>
<div class="mb-3">
    <a href="{{route('lession.create')}}" class="btn btn-success" data-bs-toggle="modal"
    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>
</div>
{{-- create --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="uploadModalLabel">បញ្ចូលមេរៀន</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lession.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Course Selection --}}
                    <div class="mb-3">
                        <label for="course" class="form-label">Course:</label>
                        <select name="course_id" class="form-control" required>
                            <option value="" disabled selected>Select a course</option>
                            @foreach ($course as $courses)
                                <option value="{{ $courses->id }}" {{ old('course_id') == $courses->id ? 'selected' : '' }}>
                                    {{ $courses->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    {{-- Lesson Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ old('title') }}" required>
                    </div>
    
                    {{-- Lesson Content --}}
                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea name="content" id="content" class="form-control" required>{{ old('content') }}</textarea>
                    </div>
    
                    {{-- Video URL --}}
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL:</label>
                        <input type="url" name="video_url" id="video_url" class="form-control"
                            value="{{ old('video_url') }}" required>
                    </div>
    
                    {{-- Order Number --}}
                    <div class="mb-3">
                        <label for="order_num" class="form-label">Order Number:</label>
                        <input type="number" name="order_num" class="form-control" 
                            value="{{ old('order_num') }}" required step="0" min="0">
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
      <div class="card p-5">
         
          <table class="table table-hover">
            <thead>
              <th>ID</th>
              <th>Course Name</th>
              <th>Title</th>
              <th>Content</th>
              <th>Video</th>
              <th>Order Number</th>
              <th>option</th>
            </thead>
            <tbody>
              @foreach($lession as $lessions)
              <tr>
                <td>{{ $lessions->id }}</td>
                <td>{{ $lessions->course->course_name }}</td>
                <td>{{ $lessions->title }}</td>
                <td>{{ $lessions->content }}</td>
                <td><a href="{{ $lessions->video_url }}" target="_blank">{{ $lessions->video_url }}</a></td>
                <td>{{ $lessions->order_num }}</td>
                  <td>
                    <a href="{{route('lession.show',$lessions->id)}}" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{route('lession.edit',$lessions->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('lession.destroy', $lessions->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-deleted" data-id="{{$lessions->id}}" data-name="{{$lessions->title}}"><i class="fa-solid fa-trash"></i></button>
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
                        deleteForm.action = `{{ url('lession/${sliderId}') }}`;
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