@extends('layouts.app')
@section('content')
<div class="row justify-content-center pb-3">
    <div class="col-md-10 ">
        <div class="card p-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-center fs-5 text-primary text-decoration-underline">Submission</div>
            <form action="{{ route('submission.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user" class="form-label">User:</label>
                    <select name="user_id" class="form-control" required>
                        @foreach ($user as $users)
                            <option value="{{ $users->id }}">{{ $users->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="assignment" class="form-label">Assignment Title:</label>
                    <select name="assignment_id" class="form-control" required>
                        @foreach ($assignment as $assignments)
                            <option value="{{ $assignments->id }}">{{ $assignments->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="submission_date" class="form-label">Submission Date:</label>
                    <input type="date" name="submission_date" class="form-control" value="{{ old('submission_date') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="grade" class="form-label">grade:</label>
                    <input type="text" name="grade" id="grade" class="form-control"
                        value="{{ old('grade') }}" required>
                </div>
                <div class="mb-3">
                    <label for="feedback" class="form-label">feedback:</label>
                    <textarea name="feedback" id="feedback" class="form-control" required>{{ old('feedback') }}</textarea>
                    {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                </div>
                
                <div class="text-center "><button class="btn btn-primary" type="submit">រក្សាទុក</button></div>
            </form>
        </div>
    </div>
</div>
@endsection