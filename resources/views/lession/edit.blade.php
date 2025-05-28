@extends('layouts.master')

@section('content')
<div class="row justify-content-center home-content pb-3">
    <div class="col-md-8">
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

            <div class="text-center fs-5 text-primary text-decoration-underline">កែប្រែមេរៀន</div>

            <form action="{{ route('lession.update',$lession->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- Course Selection --}}
                <div class="mb-3">
                    <label for="course" class="form-label">មុខវិជ្ជា:</label>
                    <select name="course_id" class="form-control" required>
                        <option value="" disabled selected>ជ្រើសរើសមុខវិជ្ជា</option>
                        @foreach ($course as $courses)
                            <option value="{{ $courses->id }}" {{$courses->course_id == $courses->id ? 'selected' : '' }}>
                                {{ $courses->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Lesson Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label">ចំណងជើង:</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ $lession->title }}" required>
                </div>

                {{-- Lesson Content --}}
                <div class="mb-3">
                    <label for="content" class="form-label">មាតិកា:</label>
                    <textarea name="content" id="content" class="form-control" required>{{ $lession->content }}</textarea>
                </div>

                {{-- Video URL --}}
                 <div class="mb-3">
                    <label for="video_url" class="form-label">វីដេអូ:</label>
                    <input type="file" name="video_url" id="video_url" class="form-control" accept="video/*">
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
