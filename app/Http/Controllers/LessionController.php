<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessionController extends Controller
{
    // public function index(){
    //     $lession=Lession::all();
    //     $course=Course::all();
    //     return view('lession.index',compact('lession','course'));
    // }
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

    public function create(){
        $course=Course::all();
        return view('lession.create',compact('course'));
    }
  
  public function store(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'video_url' => 'required|file|mimes:mp4,mov,avi,flv|max:204800', // Max 100MB
    ]);

    // Store video in storage/app/public/videos
    $path = $request->file('video_url')->store('videos', 'public');

    // Save to database
    $lesson = Lession::create([
        'course_id' => $validated['course_id'],
        'title' => $validated['title'],
        'video_url' => $path, // stored path
    ]);

    return redirect()->route('lession.index')->with('success', 'Video uploaded successfully!');
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
        'video' => 'sometimes|file|mimes:mp4,mov,avi,wmv|max:204800',
    ]);

    if ($request->hasFile('video')) {
        // Delete old video if needed
        if ($lession->video_url && Storage::disk('public')->exists($lession->video_url)) {
            Storage::disk('public')->delete($lession->video_url);
        }

        $path = $request->file('video')->store('videos', 'public');
        $lession->video_url = $path;
    }

    if ($request->has('title')) $lession->title = $request->title;
    if ($request->has('course_id')) $lession->course_id = $request->course_id;

    $lession->save();

    return redirect()->route('lession.index')->with('success','Lession updated successfully!');
}


    public function show($id){
         $lession=Lession::findOrFail($id);
         return view('lession.show', compact('lession'));
    }
    
//     public function update(Request $request, $id)
// {
//     $validated = $request->validate([
//         'course_id' => 'required|exists:courses,id',
//         'title' => 'required|string|max:255',
//         'video_url' => 'nullable|file|mimes:mp4,mov,avi,flv|max:102400', // optional video update
//     ]);

//     $lesson = Lession::findOrFail($id);

//     // Handle new video upload if present
//     if ($request->hasFile('video_url')) {
//         // Optionally delete old video
//         if ($lesson->video_url && Storage::disk('public')->exists($lesson->video_url)) {
//             Storage::disk('public')->delete($lesson->video_url);
//         }

//         // Upload new video
//         $path = $request->file('video_url')->store('videos', 'public');
//         $lesson->video_url = $path;
//     }

//     // Update other fields
//     $lesson->course_id = $validated['course_id'];
//     $lesson->title = $validated['title'];
//     $lesson->save();

//     return redirect()->route('lession.index')->with('success', 'Lesson updated successfully!');
// }

    public function destroy($id){
        $lession=Lession::findOrFail($id);
        $lession->delete();
        return redirect()->route('lession.index')->with('success','Lession deleted successfully!');
    }
}
