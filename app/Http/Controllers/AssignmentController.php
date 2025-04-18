<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use COM;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(){
        $course=Course::all();
        $assignment=Assignment::all();
        return view('assignment.index',compact('assignment','course'));
    }
    public function create(){
        $course=Course::all();
        return view('assignment.create',compact('course'));
    }
    public function store(Request $request){
        $request->validate([
            'course_id'=>'required|exists:courses,id',
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'due_date'=>'required|date',
            'max_score'=>'required|numeric',
        ]);
        Assignment::create($request->all());
        return redirect()->route('assignment.index')->with('success','Assignment created successfully!');
    }
    public function edit($id){
        $assignment=Assignment::findOrFail($id);
        $course=Course::all();
        return view('assignment.edit',compact('assignment','course'));
    }
    public function update(Request $request,$id){
        $request->validate([
            'course_id'=>'required|exists:courses,id',
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'due_date'=>'required|date',
            'max_score'=>'required|numeric',
        ]);
        $assignment=Assignment::findOrFail($id);
        $assignment->update($request->all());
        return redirect()->route('assignment.index')->with('success','Assignment updated successfully!');
    }
    public function destroy($id){
        $assignment=Assignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('assignment.index')->with('success','Assignment delete successfully!');
    }
}
