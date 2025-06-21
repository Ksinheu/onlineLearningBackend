<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lession;
use Illuminate\Http\Request;

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

    $courses=Course::all();
    $lessons=Lession::all();
    $i = (request()->input('page', 1) - 1) * 5;

    return view('content.index', compact('contents', 'i','courses','lessons'));
}
public function getLessonsByCourse($courseId)
{
    $lessons = Lession::where('course_id', $courseId)->get();

    if ($lessons->isEmpty()) {
        return response()->json([
            'message' => 'No lessons found for this course.'
        ], 404);
    }

    return response()->json([
        'message' => 'Lessons retrieved successfully!',
        'lessons' => $lessons
    ]);
}

    public function create()
    {
        $courses = Course::all();
        $lessons = Lession::all();
        return view('content.create', compact('courses', 'lessons'));
    }

    public function store(Request $request)
    {
       $request->validate([
    'course_id' => 'required|exists:courses,id',
    'lesson_id' => 'required|exists:lessions,id',
    'session' => 'required|string',
    'expect_result' => 'required|string',
    'Lesson_content' => 'required|string',
    'activity' => 'required|string',
    'Evaluate' => 'required|string',
]);


        Content::create($request->all());
        return redirect()->route('content.index')->with('success', 'Content created successfully.');
    }

    public function edit(Content $content)
    {
        $courses = Course::all();
        $lessons = Lession::all();
        return view('content.edit', compact('content', 'courses', 'lessons'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'course_id' => 'required',
            'lesson_id' => 'required',
            'session' => 'required',
            'expect_result' => 'required',
            'Lesson_content' => 'required',
            'activity' => 'required',
            'Evaluate' => 'required',
        ]);

        $content->update($request->all());
        return redirect()->route('content.index')->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('content.index')->with('success', 'Content deleted successfully.');
    }
}
