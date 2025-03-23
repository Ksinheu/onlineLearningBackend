@extends('layouts.app')

@section('content')
<div class="row justify-content-center pb-3">
    <div class="col-md-10">
        <div class="card p-5">
            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="text-center fs-5 text-primary text-decoration-underline">បញ្ចូលមេរៀន</div>

            <form action="{{ route('lession.store') }}" method="POST">
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
@endsection
