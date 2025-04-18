@extends('layouts.master')
@section('content')
<div class="col-md-12 pb-3">
    <div class="card p-5">
        <div class="text-center fs-5 text-primary text-decoration-underline">កែប្រែមុខវិជ្ជា</div>
        <form action="{{ route('assignment.update',$assignment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="course" class="form-label">Course:</label>
                <select name="course_id" class="form-control" required>
                    @foreach ($course as $courses)
                        <option value="{{ $courses->id }}" {{$courses->course_id == $courses->id ? 'selected' : '' }}>{{ $courses->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ $assignment->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control" required>{{$assignment->description}}</textarea>
                {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
            </div>
            

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date:</label>
                <input type="date" name="due_date" class="form-control" value="{{$assignment->due_date }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="max_score" class="form-label">Max score:</label>
                <input type="number" name="max_score" id="max_score" class="form-control" value="{{ $assignment->max_score }}"
                    required>
            </div>
            <div class="text-center "><button class="btn btn-primary" type="submit">កែប្រែ</button></div>
        </form>
    </div>
</div>
@endsection