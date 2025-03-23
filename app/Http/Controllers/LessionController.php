<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lession;
use Illuminate\Http\Request;

class LessionController extends Controller
{
    public function index(){
        $lession=Lession::all();
        $course=Course::all();
        return view('lession.index',compact('lession','course'));
    }
    public function create(){
        $course=Course::all();
        return view('lession.create',compact('course'));
    }
    public function store(Request $request){
        $request->validate([
            'course_id'=>'required|exists:courses,id',
            'title'=>'required|string|max:255',
            'content'=>'required|string|max:255',
            'video_url'=>'required|url',
            'order_num'=>'required|integer|min:0',
        ]);
        Lession::create($request->all());
        return redirect()->route('lession.index')->with('success','Lession created successfully!');
    }
    public function show($id){

    }
    public function edit($id){
        $lession=Lession::findOrFail($id);
        $course=Course::all();
        return view('lession.edit',compact('lession','course'));
    }
    public function update(Request $request,$id){
        $request->validate([
            'course_id'=>'required|exists:courses,id',
            'title'=>'required|string|max:255',
            'content'=>'required|string|max:255',
            'video_url'=>'required|string',
            'order_num'=>'required|numeric',
        ]);
        $lession=Lession::findOrFail($id);
        $lession->update($request->all());
        return redirect()->route('lession.index')->with('success','Lession Updated successfully!');
    }
    public function destroy($id){
        $lession=Lession::findOrFail($id);
        $lession->delete();
        return redirect()->route('lession.index')->with('success','Lession deleted successfully!');
    }
}
