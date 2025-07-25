<!-- resources/views/course/lessons.blade.php -->
@extends('layouts.master')
@section('content')
    <div class="home-content">
       
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
               
                <!-- Centered title -->
                <h5 class="mb-0 text-primary text-center flex-grow-1">មេរៀនសម្រាប់មុខវិជ្ជា: {{ $course->course_name }}</h5>

                <!-- Search form aligned right -->
                <form action="{{  route('courses.lessons', $course->id) }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control form-control-md me-2"
                        placeholder="ស្វែងរកមេរៀន..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-search"></i></button>
                </form>

            </div>
        </div>
       <div class="card mt-4 mb-5">
        <div class="card-body">
             @if ($course->lession->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ចំណងជើង</th>
                        <th>ឯកសារ</th>
                        <th>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->lession as $i => $lesson)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $lesson->title }}</td>
                            <td>{{ Str::limit($course->course_name, 50) }}</td>
                            
                            <td>
                                <a href="{{ route('lession.show', $lesson->id) }}" class="btn btn-warning"
                                    data-bs-toggle="modal" data-bs-target="#showModal{{ $lesson->id }}"><i
                                        class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('lession.edit', $lesson->id) }}" class="btn btn-info"
                                    data-bs-toggle="modal" data-bs-target="#updateModal{{ $lesson->id }}"><i
                                        class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('lession.destroy', $lesson->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-deleted" data-id="{{ $lesson->id }}"
                                        data-name="{{ $lesson->title }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">មិនមានមេរៀនសម្រាប់មុខវិជ្ជានេះទេ។</div>
        @endif
        </div>
       </div>
    </div>
@endsection
