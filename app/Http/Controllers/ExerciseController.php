<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\ExerciseImage;
use App\Models\Lession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExerciseController extends Controller
{
    public function index(){
        $exercise=Exercise::latest()->paginate(5);
        $lesson=Lession::all();
        return view('exercise.index',compact('exercise','lesson'));
    }
    public function create(){
        $lesson=Lession::all();

        return view('exercise.create',compact('lesson'));
    }
     // ✅ Store exercise + multiple images
     public function store(Request $request)
     {
         $request->validate([
             'lesson_id' => 'required|exists:lessions,id',
             'exercise_element' => 'required|string',
             'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // optional, multiple images
         ]);
 
         // 1. Create the exercise
         $exercise = Exercise::create([
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
        return redirect()->route('exercise.index')->with('success','Exercise created successfully!');
     }
 
     // ✅ Show single exercise with images
     public function show($id)
     {
         $exercise = Exercise::with('exerciseImage')->findOrFail($id);
         return response()->json($exercise);
     }
public function edit($id){
    $exercise = Exercise::findOrFail($id);
    $lession=Lession::all();
    return view('exercise.edit',compact('exercise','lession'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'lesson_id' => 'required|exists:lessions,id',
        'exercise_element' => 'required|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // optional, multiple images
    ]);

    // 1. Find the exercise
    $exercise = Exercise::findOrFail($id);

    // 2. Update the exercise
    $exercise->update([
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
    // 1. Find the exercise
    $exercise = Exercise::findOrFail($id);

    // 2. Delete related images from storage and database
    $exercise->exerciseImage()->get()->each(function ($img) {
        Storage::disk('public')->delete($img->image_path); // Delete file
        $img->delete(); // Delete DB record
    });

    // 3. Delete the exercise itself
    $exercise->delete();

    return redirect()->route('exercise.index')->with('success', 'Exercise deleted successfully!');
}


}
