@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-5 pb-3">
    <div class="col-md-10 card p-5">
        <div class="text-center text-primary fs-5 p-3">បញ្ចូលព័ត៌មានថ្មីៗ</div>
    @if(session('imagePath'))
    {{-- <p>Uploaded Image:</p>
    <img src="{{ asset('storage/' . session('imagePath')) }}" width="200"> --}}
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            Image created successfully!
          </div>
          {{-- <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button> --}}
        </div>
      </div>
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
@endsection
