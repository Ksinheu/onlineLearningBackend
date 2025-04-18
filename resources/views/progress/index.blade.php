<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Progress Tracker</h2>

        @foreach($progress as $entry)
            <div class="p-3 border-b flex justify-between items-center 
                {{ $entry->completed ? 'bg-green-200' : 'bg-yellow-100' }}">
                <span>Lesson: {{ $entry->lesson->title }}</span>
                <div>
                    @if(!$entry->completed)
                        <form action="{{ route('progress.update', $entry->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Mark as Completed</button>
                        </form>
                    @endif
                    <form action="{{ route('progress.delete', $entry->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>
