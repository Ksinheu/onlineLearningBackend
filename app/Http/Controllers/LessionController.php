<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lession;
use Illuminate\Http\Request;


class LessionController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $lession = Lession::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5);

    $course = Course::all();
    $i = (request()->input('page', 1) - 1) * 5;

    return view('lession.index', compact('lession', 'course', 'i'));
}
    public function ApiIndex()
{
    $lessons = Lession::all();

    // Optional: return 404 if no lessons found
    if ($lessons->isEmpty()) {
        return response()->json([
            'message' => 'No lessons found.'
        ], 404);
    }

    return response()->json([
        'message' => 'Lessons retrieved successfully!',
        'lessons' => $lessons
    ]);
}
public function countLessonsByCourse($courseId)
{
    $count = Lession::where('course_id', $courseId)->count();

    return response()->json([
        'success' => true,
        'course_id' => $courseId,
        'lesson_count' => $count
    ]);
}

    public function create(){
        $course=Course::all();
        return view('lession.create',compact('course'));
    }
  public function store(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
    ]);
    // Save to database
    $lesson = Lession::create([
        'course_id' => $validated['course_id'],
        'title' => $validated['title'],
    ]);

    return redirect()->route('lession.index')->with('success', 'Video uploaded successfully!');
}
 public function getLessonsByCourse($courseId)
{
    $lessons = Lession::where('course_id', $courseId)->get();
    if ($lessons->isEmpty()) {
        return response()->json([
            'message' => 'No lessons found for this course!'
        ], 404);
    }
    return response()->json([
        'message' => 'Lessons retrieved successfully!',
        'lesson' => $lessons
    ]);
}
public function edit($id){
        $lession=Lession::findOrFail($id);
        $course=Course::all();
        return view('lession.edit',compact('lession','course'));
    }
public function update(Request $request, $id)
{
    $lession = Lession::findOrFail($id);

    $request->validate([
        'course_id' => 'sometimes|exists:courses,id',
        'title' => 'sometimes|string|max:255',
    ]);

    if ($request->has('title')) $lession->title = $request->title;
    if ($request->has('course_id')) $lession->course_id = $request->course_id;

    $lession->save();

    return redirect()->route('lession.index')->with('success','Lession updated successfully!');
}


    public function show($id){
         $lession=Lession::findOrFail($id);
         return view('lession.show', compact('lession'));
    }

    public function destroy($id){
        $lession=Lession::findOrFail($id);
        $lession->delete();
        return redirect()->route('lession.index')->with('success','Lession deleted successfully!');
    }

    public function contents(Request $request, $lessonID)
{
    $search = $request->input('search');

    $lesson = Lession::findOrFail($lessonID);

    $contents = $lesson->content()
        ->when($search, function ($query, $search) {
            return $query->where('lesson_content', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5);

    return view('lession.contents', compact('lesson', 'contents'));
}

}
