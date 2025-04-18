@extends('layouts.master')
@section('content')
    <div class="col-md-12 pb-3">
        <div class="card p-5">
            <div class="text-center fs-5 text-primary text-decoration-underline">កែប្រែមុខវិជ្ជា</div>
            <form action="{{ route('course.update',$course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="user" class="form-label">User:</label>
                    <select name="user_id" class="form-control" required>
                        @foreach ($user as $users)
                            <option value="{{ $users->id }}" {{$users->user_id == $users->id ? 'selected' : '' }}>{{ $users->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="course_name" class="form-label">Course Name:</label>
                    <input type="text" name="course_name" id="course_name" class="form-control"
                        value="{{$course->course_name}}" required>
                </div>
                <div class="mb-3">
                    <input type="file" class="form-control" name="imgCourse" required>   
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
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $course->start_date }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $course->end_date }}" required>
                </div>
                <div class="text-center "><button class="btn btn-primary" type="submit">កែប្រែ</button></div>
            </form>
        </div>
    </div>
@endsection