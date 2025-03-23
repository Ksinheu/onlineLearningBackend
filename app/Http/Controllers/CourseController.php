<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(){
        $course=Course::all();
        $user=User::all();
        return view('course.index',compact('course','user'));
    }
    public function create(){
        $user=User::all();
        return view('course.create',compact('user'));
    }
    public function store(Request $request){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'course_name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'price'=>'required|numeric',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        Course::create($request->all());
        return redirect()->route('course.index')->with('success','Course created successfully!');
    }
    public function show($id){
        
    }
    public function edit($id){
        $course=Course::findOrFail($id);
        $user=User::all();
        return view('course.edit',compact('course','user'));
    }
    public function update(Request $request,$id){
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'course_name'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'price'=>'required|numeric',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        $course=Course::findOrFail($id);
        $course->update($request->all());
        return redirect()->route('course.index')->with('success','Course Updated successfully!');
    }
    public function destroy($id){
        $course=Course::findOrFail($id);
        $course->delete();
        return redirect()->route('course.index')->with('success','Course deleted successfully!');
    }
}
