@extends('layouts.app')
@section('content')
<div class="row justify-content-center mt-4 pb-3">
    <div class="col-md-10">
        <div class="card p-4">
        <div class="text-center text-primary fs-5 p-3">កែប្រែរូបស្លាយ</div>
        
        <form action="{{ route('slider.update',$slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="file" class="form-control" name="image" required>   
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</div>
</div>
@endsection
