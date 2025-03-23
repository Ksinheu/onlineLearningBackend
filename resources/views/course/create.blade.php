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
                <div class="text-center fs-5 text-primary text-decoration-underline">បញ្ចលមុខវិជ្ជា</div>
                {{-- <div class="positon-end">
                <a href="" class="btn brn-succes">បង្កើត</a>
            </div> --}}
                <form action="{{ route('course.store') }}" method="POST">
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
                        <label for="course_name" class="form-label">Course Name:</label>
                        <input type="text" name="course_name" id="course_name" class="form-control"
                            value="{{ old('course_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                        {{-- <input type="address" name="description" id="description" class="form-control" required> --}}
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price($):</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
                    <div class="text-center "><button class="btn btn-primary" type="submit">រក្សាទុក</button></div>
                </form>
            </div>
        </div>
    </div>
@endsection
