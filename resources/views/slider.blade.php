@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-12">
        <div class="card p-4">
        <div class="text-center text-primary fs-5 p-3">បញ្ចូលរូបភាពទៅក្នុងស្លាយ</div>
    @if(session('imagePath'))
    <p>Uploaded Image:</p>
    <img src="{{ asset('storage/' . session('imagePath')) }}" width="200">
    @endif
        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control" name="image" required>   
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
</div>
@endsection
