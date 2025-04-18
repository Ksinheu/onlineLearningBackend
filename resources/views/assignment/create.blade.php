@extends('layouts.master')
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
            <div class="text-center fs-5 text-primary text-decoration-underline">បញ្ចលមុខវិជ្ជា</div>
            <form action="{{ route('assignment.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="course" class="form-label">Course:</label>
                    <select name="course_id" class="form-control" required>
                        @foreach ($course as $courses)
                            <option value="{{ $courses->id }}">{{ $courses->course_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" name="title" id="title" class="form-control"
                        value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                    {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                </div>
                

                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="max_score" class="form-label">max_score:</label>
                    <input type="number" name="max_score" id="max_score" class="form-control" value="{{ old('max_score') }}"
                        required>
                </div>
                
                <div class="text-center "><button class="btn btn-primary" type="submit">រក្សាទុក</button></div>
            </form>
        </div>
    </div>
</div>
@endsection