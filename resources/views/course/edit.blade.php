@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 home-content pb-3">
        <div class="card p-5">
            <div class="text-center fs-5 text-primary text-decoration-underline">កែប្រែមុខវិជ្ជា</div>
            <form action="{{ route('course.update',$course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="user" class="form-label">User:</label>
                    <select name="user_id" class="form-control" required>
                        @foreach ($user as $users)
                        <option value="{{ $users->id }}" {{ $course->user_id == $users->id ? 'selected' : '' }}>{{ $users->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name:</label>
                    <input type="text" name="course_name" id="course_name" class="form-control"
                        value="{{$course->course_name}}" required>
                </div>
                <div class="mb-3">
                    {{-- @if ($course->imgCourse)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $course->imgCourse) }}" alt="" style="max-width: 150px;">
                        </div>
                    @endif
                    <label for="imgCourse" class="form-label">Image:</label>
                    <input type="file" class="form-control" name="imgCourse" accept="image/*" >    --}}
                    <label for="imgCourse">QR Code:</label>
                    @if ($course->imgCourse)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $course->imgCourse) }}" alt="Current QR Code" style="max-width: 150px;">
                        </div>
                    @endif
                    <input type="file" name="imgCourse" class="form-control" id="imgCourse" accept="image/*">
                    <small class="text-muted">Leave blank if you don't want to change the QR code.</small>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" id="description" class="form-control" required>{{ $course->description}}</textarea>
                    {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price($):</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ $course->price }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="price_normal" class="form-label">Price normal($):</label>
                    <input type="number" name="price_normal" id="price_normal" class="form-control" value="{{ $course->price_normal }}"
                        required>
                </div>

                
                <div class="text-center "><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> កែប្រែ</button></div>
            </form>
        </div>
    </div>
</div>
@endsection