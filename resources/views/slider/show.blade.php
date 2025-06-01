@extends('layouts.master')

@section('content')
<div class="row justify-content-center mt-5 pb-3">
    <div class="col-md-8 mt-5">
        <div class="card p-4 text-center">
            <h5 class="text-primary">មើលរូបស្លាយ</h5>
            
            <img src="{{ Storage::url($slider->image)  }}" class="img-fluid w-100 mt-3" alt="Slider Image"  id="sliderImage">
            
            <div class="mt-3">
                <a href="{{ route('slider.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>

@endsection
