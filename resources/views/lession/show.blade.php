@extends('layouts.master')
@section('content')
<div class="container home-content">
        <h1>{{ $lession->title }}</h1>
        <p><strong>Course:</strong> {{$lession->course->name }}</p>
        <p><strong>Content:</strong> {{ $lession->content }}</p>
        <h3>Video</h3>
         <video controls>
            <source src="{{ asset('storage/' . $lession->video_url) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
           
        <a href="{{ route('lession.index') }}" class="btn btn-secondary mt-3">Back to Lessons</a>
    </div>
    
@endsection