@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-4 pb-3">
    <div class="col-md-8">
        <div class="card p-4 text-center">
            <h5 class="text-primary">View News Image</h5>
            
            <img src="{{ Storage::url($news->imageNews)  }}" class="img-fluid mt-3" alt="Slider Image" width="500" id="sliderImage">
            
            <div class="mt-3">
                <a href="{{ route('news.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>

@endsection
