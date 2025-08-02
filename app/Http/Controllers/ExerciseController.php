<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\ExerciseImage;
use App\Models\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $exercise = Exercise::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
            ->latest()
            ->paginate(5);

        $courses = Course::all();
    $selectedCourseId = $request->old('course_id'); // use old() to restore after validation error

    $lessons = $selectedCourseId
        ? Lession::where('course_id', $selectedCourseId)->get()
        : collect(); // empty collection initially
        $i = (request()->input('page', 1) - 1) * 5;

        return view('exercise.index', compact('exercise', 'lessons', 'i', 'courses','selectedCourseId'));
    }
public function create(Request $request)
{
    $courses = Course::all();
    $selectedCourseId = $request->old('course_id'); // use old() to restore after validation error

    $lessons = $selectedCourseId
        ? Lession::where('course_id', $selectedCourseId)->get()
        : collect(); // empty collection initially

    return view('exercise.create', compact('courses', 'lessons', 'selectedCourseId'));
}

public function getLessonsByCourse($courseId)
{
    $lessons = Lession::where('course_id', $courseId)->get();
    return response()->json($lessons);
}

    // ✅ Store exercise + multiple images
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessions,id',
            'exercise_element' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // optional, multiple images
        ]);

        // 1. Create the exercise
        $exercise = Exercise::create([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'exercise_element' => $request->exercise_element,
        ]);

        // 2. Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('exercise_images', 'public');

                ExerciseImage::create([
                    'exercise_id' => $exercise->id,
                    'image_path' => $path,
                ]);
            }
        }

        //  return response()->json(['message' => 'Exercise created', 'exercise' => $exercise->load('exerciseImage')], 201);
        return redirect()->route('exercise.index')->with('success', 'Exercise created successfully!');
    }
    public function showApi($courseId)
{
    $exercises=Exercise::with('course','lesson','exerciseImage')->where('course_id',$courseId)->get();
    return response()->json([
        'status' => true,
        'lesson_id' => $courseId,
        'exercises' => $exercises
    ]);
}

 public function edit($id)
{
    $exercise = Exercise::findOrFail($id);
    $courses = Course::all();
    $selectedCourseId = $exercise->course_id;

    $lessons = $selectedCourseId
        ? Lession::where('course_id', $selectedCourseId)->get()
        : collect();

    return view('exercise.edit', compact('exercise', 'courses', 'lessons', 'selectedCourseId'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessions,id',
            'exercise_element' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // optional, multiple images
        ]);

        // 1. Find the exercise
        $exercise = Exercise::findOrFail($id);

        // 2. Update the exercise
        $exercise->update([
            'course_id' => $request->course_id,
            'lesson_id' => $request->lesson_id,
            'exercise_element' => $request->exercise_element,
        ]);

        // 3. Handle image upload (delete old images if new ones provided)
        if ($request->hasFile('images')) {
            // Delete existing images
            $exercise->exerciseImage()->get()->each(function ($img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            });

            // Upload new images
            foreach ($request->file('images') as $img) {
                $path = $img->store('exercise_images', 'public');

                ExerciseImage::create([
                    'exercise_id' => $exercise->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('exercise.index')->with('success', 'Exercise updated successfully!');
    }
    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);

        // Delete related images
        $exercise->exerciseImage()->get()->each(function ($img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        });

        $exercise->delete();

        return redirect()->route('exercise.index')->with('success', 'Exercise deleted successfully!');
    }
}
