@extends('layouts.master')

@section('content')
<div class="container home-content">
    <h2>កែប្រែលំហាត់</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('exercise.update', $exercise->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Lesson ID -->
        <div class="mb-3">
            <label for="lesson_id" class="form-label">Lesson</label>
            <select name="lesson_id" id="lesson_id" class="form-control">
                @foreach($lession as $lessions)
                    <option value="{{ $lessions->id }}" {{ $lessions->id == $exercise->lesson_id ? 'selected' : '' }}>
                        {{ $lessions->title }}
                    </option>
                @endforeach
            </select>
            @error('lesson_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Exercise Element -->
        <div class="mb-3">
            <label for="exercise_element" class="form-label">Exercise Element</label>
            <input type="text" name="exercise_element" id="exercise_element" class="form-control" value="{{ old('exercise_element', $exercise->exercise_element) }}">
            @error('exercise_element')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Existing Images -->
        <div class="mb-3">
            <label class="form-label">Current Images:</label><br>
            @foreach($exercise->exerciseImage as $img)
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Exercise Image" width="100" class="me-2 mb-2">
            @endforeach
        </div>

        <!-- Upload New Images -->
        <div class="mb-3">
            <label for="images" class="form-label">Add More Images</label>
            <input type="file" name="images[]" multiple class="form-control">
            @error('images.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Exercise</button>
    </form>
</div>
@endsection
