@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-4 pb-3">
    <div class="col-md-10">
        <div class="card p-4">
        <div class="text-center text-primary fs-5 p-3">បញ្ចូលព័ត៌មានថ្មីៗ</div>
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
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control" name="imageNews" required>   
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
</div>
@endsection
