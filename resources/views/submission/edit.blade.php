@extends('layouts.app')
@section('content')
<div class="col-md-12 pb-3">
    <div class="card p-5">
        <div class="text-center fs-5 text-primary text-decoration-underline">កែប្រែមុខវិជ្ជា</div>
        <form action="{{ route('assignment.update',$assignment->id) }}" method="POST">
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
                <label for="assignment" class="form-label">Assignment Title:</label>
                <select name="assignment_id" class="form-control" required>
                    @foreach ($assignment as $assignments)
                        <option value="{{ $assignments->id }}" {{$assignments->assignment_id == $assignments->id ? 'selected' : ''}}>{{ $assignments->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="submission_date" class="form-label">Submission Date:</label>
                <input type="date" name="submission_date" class="form-control" value="{{ $submission->submission_date }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="grade" class="form-label">grade:</label>
                <input type="text" name="grade" id="grade" class="form-control"
                    value="{{ $submission->grade }}" required>
            </div>
            <div class="mb-3">
                <label for="feedback" class="form-label">feedback:</label>
                <textarea name="feedback" id="feedback" class="form-control" required>{{ $submission->feedback }}</textarea>
            </div>
            
            <div class="text-center "><button class="btn btn-primary" type="submit">កែប្រែ</button></div>
        </form>
    </div>
</div>
@endsection