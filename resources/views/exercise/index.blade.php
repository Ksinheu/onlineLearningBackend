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

@if(session('success'))
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
<div class="text-center fs-5 text-primary text-decoration-underline">លំហាត់</div>
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
                <form action="{{ route('exercise.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Course Selection --}}
                    <div class="mb-3">
                        <label for="lesson" class="form-label">lesson:</label>
                        <select name="lesson_id" class="form-control" required>
                            <option value="" disabled selected>Select a lesson</option>
                            @foreach ($lesson as $lessons)
                                <option value="{{ $lessons->id }}" {{ old('lesson_id') == $lessons->id ? 'selected' : '' }}>
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
      <div class="card p-5">
         
          <table class="table table-hover">
            <thead>
              <th>ID</th>
              <th>lesson</th>
              <th>exercise_element</th>
              <th>exercise_images</th>
              <th>option</th>
            </thead>
            <tbody>
              @foreach($exercise as $exercises)
              <tr>
                <td>{{ $exercises->id }}</td>
                <td>{{ $exercises->lesson->title ?? 'N/A' }}</td>
                <td>{{ $exercises->exercise_element }}</td>
                <td>
                    @foreach ($exercises->exerciseImage as $img)
        <img src="{{ asset('storage/' . $img->image_path) }}" width="60" height="60" class="me-1 mb-1 rounded">
    @endforeach
                </td>
                
                  <td>
                    <a href="{{route('exercise.show',$exercises->id)}}" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{route('exercise.edit',$exercises->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('exercise.destroy', $exercises->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-deleted" data-id="{{$exercises->id}}" data-name="{{$exercises->id}}"><i class="fa-solid fa-trash"></i></button>
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
                        deleteForm.action = `{{ url('exercise/${sliderId}') }}`;
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