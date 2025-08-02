<!-- resources/views/course/lessons.blade.php -->
@extends('layouts.master')
@section('content')
    <div class="home-content">

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <!-- Centered title -->
                <h5 class="mb-0 text-primary text-center flex-grow-1">មេរៀនសម្រាប់មុខវិជ្ជា: {{ $lesson->title }}</h5>

                <!-- Search form aligned right -->
                <form action="{{ route('lession.contents', $lesson->id) }}" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" name="search" class="form-control form-control-md me-2"
                        placeholder="ស្វែងរកមេរៀន..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-search"></i></button>
                </form>

            </div>
        </div>
        <div class="card mt-4 mb-5">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>មុខវិជ្ជា</th>
                            <th>មេរៀន</th>
                            <th>រយៈពេល</th>
                            <th>មាតិកា</th>
                            <th>លទ្ធផល</th>
                            {{-- <th>សកម្មភាព</th> --}}
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($contents as $index => $content)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $content->course->course_name ?? 'N/A' }}</td>
                                <td>{{ $content->lesson->title ?? 'N/A' }}</td>
                                <td>{{ $content->session }}</td>
                                <td>{{ Str::limit($content->Lesson_content, 10) }}</td>
                                <td>{{ Str::limit($content->expect_result, 10) }}</td>
                                {{-- <td>
                                        <a href="#" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#showModal{{ $content->id }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $content->id }}">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('content.destroy', $content->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-deleted"
                                                data-id="{{ $content->id }}" data-name="Content {{ $content->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td> --}}
                            </tr>

                            {{-- Show & Edit Modals --}}
                            {{-- @include('content.partials.edit', ['content' => $contents]) --}}
                            {{-- @include('content.partials.show', ['content' => $content]) --}}
                        @endforeach
                    </tbody>
                    
                </table>

            </div>
        </div>
    </div>
@endsection
