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
        <div class="card p-5">
            <div class="mb-3">
                <a href="{{ route('slider.create') }}" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i> បង្កើត</a>
            </div>

            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">បញ្ចូលរូបភាពស្លាយ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="image" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>ImageSlider</th>
                    <th>option</th>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>
                            <td><img src="{{ Storage::url($slider->image) }}" alt="" width="50px" height="50px">
                            </td>
                            <td>
                                <a href="{{ route('slider.show', $slider->id) }}" class="btn btn-warning"><i
                                        class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-info"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('slider.destroy', $slider->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-deleted" data-id="{{ $slider->id }}"
                                        data-name="{{ $slider->image }}"><i class="fa-solid fa-trash"></i></button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-deleted');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
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
                            deleteForm.action = `{{ url('slider/${sliderId}') }}`;
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
