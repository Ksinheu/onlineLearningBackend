<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $course = Course::when($search, function ($query, $search) {
            return $query->where('course_name', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5);

    $user = User::all();
    $i = (request()->input('page', 1) - 1) * 5;

    return view('course.index', compact('course', 'user', 'i'));
}

    public function ApiIndex(){
        $course=Course::all();
        return response()->json([
            'message'=>'Course retrieved scussessfuly!',
            'course'=>$course
        ]);
    }
    public function create(){
        $user=User::all();
        return view('course.create',compact('user'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'course_name' => 'required|string|max:255',
        'imgCourse' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric',
        'price_normal'=> 'required|numeric',
    ]);

    // Store the image in the public disk under imgCourse folder
    $imagePath = $request->file('imgCourse')->store('imgCourse', 'public');

    // Create the course with image path
    Course::create([
        'user_id' => $validated['user_id'],
        'course_name' => $validated['course_name'],
        'imgCourse' => $imagePath, // Make sure this matches your DB column
        'description' => $validated['description'],
        'price' => $validated['price'],
        'price_normal' => $validated['price_normal'],
        
    ]);

    return back()->with('success', 'Course created successfully!')->with('imagePath', $imagePath);
}
public function show($id){
     $course=Course::findOrFail($id);
         return view('course.show', compact('course'));
}

    public function showApi($id){
        $course = Course::with('user')->find($id); // Include related user info if needed

        if (!$course) {
            return response()->json([
                'message' => 'Course not found.'
            ], 404);
        }
    
        return response()->json([
            'message' => 'Course retrieved successfully!',
            'course' => $course
        ]);
    }
    public function edit($id){
        $course=Course::findOrFail($id);
        $user=User::all();
        return view('course.edit',compact('course','user'));
    }
    public function update(Request $request, $id)
{
    $course = Course::findOrFail($id);

    $validated = $request->validate([
        'course_name' => 'required|string|max:255',
        'imgCourse' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric',
        'price_normal' => 'required|numeric',
    ]);

 if ($request->hasFile('imgCourse')) {
        // Delete old image
        if ($course->imgCourse) {
            Storage::disk('public')->delete($course->imgCourse);
        }

        // Upload new image
        $imagePath = $request->file('imgCourse')->store('images', 'public');
        $course->update(['imgCourse' => $imagePath]);
    }
    // Update other fields
    $course->course_name = $validated['course_name'];
    $course->description = $validated['description'];
    $course->price = $validated['price'];
    $course->price_normal = $validated['price_normal'];
    $course->save();

    return redirect()->route('course.index')->with('success', 'Course updated successfully!');
}

    public function destroy($id){
        $course=Course::findOrFail($id);
        // Delete the image file
        if ($course->imgCourse) {
            Storage::disk('public')->delete($course->imgCourse);
        }
        $course->delete();
        return redirect()->route('course.index')->with('success','Course deleted successfully!');
    }
}