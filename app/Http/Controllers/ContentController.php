<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ContentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $contents = Content::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(5);

        $courses = Course::all();
        $lessons = Lession::all();
        $i = (request()->input('page', 1) - 1) * 5;

        return view('content.index', compact('contents', 'i', 'courses', 'lessons'));
    }
    public function getLessonsByCourse($courseId)
    {
        $lessons = Lession::where('course_id', $courseId)->get();
        return response()->json($lessons);
    }

    public function create()
    {
        $courses = Course::all();
        $lessons = Lession::all();
        return view('content.create', compact('courses', 'lessons'));
    }

   public function store(Request $request)
{
    // Validate request data
    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'lesson_id' => 'required|exists:lessions,id', // Ensure correct table name
        'session' => 'required|string',
        'expect_result' => 'required|string',
        'Lesson_content' => 'required|string',
        'video_url' => 'required|file|mimes:mp4,mov,avi,flv|max:51200', // Max 50MB optional
        'activity' => 'required|string',
        'Evaluate' => 'required|string',
    ]);

    // Store uploaded video in storage/app/public/videos
    $path = $request->file('video_url')->store('videos', 'public');

    // Create new Content record
    Content::create([
        'course_id' => $validated['course_id'],
        'lesson_id' => $validated['lesson_id'],
        'session' => $validated['session'],
        'expect_result' => $validated['expect_result'],
        'Lesson_content' => $validated['Lesson_content'],
        'video_url' => $path, // stored file path
        'activity' => $validated['activity'],
        'Evaluate' => $validated['Evaluate'],
    ]);

    return redirect()->route('content.index')->with('success', 'Content created successfully.');
}


    public function edit(Content $content)
    {
        $courses = Course::all();
        $lessons = Lession::all();
        return view('content.edit', compact('content', 'courses', 'lessons'));
    }

    public function update(Request $request, $id)
{
    // Find the content or fail
    $content = Content::findOrFail($id);

    // Validate request data
    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'lesson_id' => 'required|exists:lessions,id',
        'session' => 'required|string',
        'expect_result' => 'required|string',
        'Lesson_content' => 'required|string',
        'video_url' => 'nullable|file|mimes:mp4,mov,avi,flv|max:51200', // Optional
        'activity' => 'required|string',
        'Evaluate' => 'required|string',
    ]);

    // Check if a new video file is uploaded
    if ($request->hasFile('video_url')) {
        // Optional: Delete old video if exists
        if ($content->video_url && Storage::disk('public')->exists($content->video_url)) {
            Storage::disk('public')->delete($content->video_url);
        }

        // Store new video
        $path = $request->file('video_url')->store('videos', 'public');
        $content->video_url = $path;
    }

    // Update other fields
    $content->course_id = $validated['course_id'];
    $content->lesson_id = $validated['lesson_id'];
    $content->session = $validated['session'];
    $content->expect_result = $validated['expect_result'];
    $content->Lesson_content = $validated['Lesson_content'];
    $content->activity = $validated['activity'];
    $content->Evaluate = $validated['Evaluate'];

    // Save changes
    $content->save();

    return redirect()->route('content.index')->with('success', 'Content updated successfully.');
}


    public function destroy($id)
    {
        $content=Content::findOrFail($id);
          // Delete image from storage (only if exists)
    if ($content->video_url && Storage::disk('public')->exists($content->video_url)) {
        Storage::disk('public')->delete($content->video_url);
    }
        $content->delete();
        return redirect()->route('content.index')->with('success', 'Content deleted successfully.');
    }

public function indexApi($id)
{
    $query = Content::with(['course', 'lesson'])
                    ->where('course_id', $id);

    $contents = $query->get();

    if ($contents->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No content found.'
        ], 404);
    }
    // Count total contents
    // $totalCount = $contents->count();
    return response()->json([
        'success' => true,
        // 'count_content'=>$totalCount,
        'contents' => $contents
    ]);
}
public function countByCourseId($id)
{
    $count = Content::where('course_id', $id)->count();

    return response()->json([
        'success' => true,
        'course_id' => $id,
        'content_count' => $count
    ]);
}

}
