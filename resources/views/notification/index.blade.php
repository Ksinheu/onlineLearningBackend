@extends('layouts.master')
@section('content')

<body class="bg-gray-100 p-6">

    <div class="max-w-7xl mx-auto bg-white p-4 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Notifications</h2>

        <div class="mb-3 justify-content-end">
            <a href="{{ route('notification.create') }}" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#uploadModal"><i class="fa-solid fa-plus"></i>បង្កើត</a>
        </div>

        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('notification.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700">User ID:</label>
                                <select name="user_id" class="form-control" required>
                                    @foreach ($user as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Content:</label>
                                <textarea name="content" class="w-full p-2 border rounded" required>{{ old('content') }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Type:</label>
                                <input type="text" name="type" class="w-full p-2 border rounded"  value="{{ old('type') }}" required>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                Create Notification
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @foreach($notifications as $notification)
        <div class="mb-3">
            <div class="p-3 border-b flex justify-between items-center 
                {{ $notification->read_status ? 'bg-gray-200' : 'bg-blue-100' }}">
                <span>{{ $notification->content }}</span>
                <div class="d-flex">
                    @if(!$notification->read_status)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-sm me-2">Mark as Read</button>
                        </form>
                    @endif
                    <form action="{{ route('notification.destroy', $notification->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
   
    </div>

</body>
@endsection
