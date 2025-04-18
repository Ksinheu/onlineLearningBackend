<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(){
        $assignment=Assignment::all();
        $user=User::all();
        return view('submission.index',compact('assignment','user'));
    }
    public function create(){
        return view('submission.create');
    }
    public function store(Request $request){
        $request->validate([
            'assignment_id'=>'required|exists:assignments,id',
            'user_id'=>'required|exists:users,id',
            'submission_date'=>'required|date',
            'grade'=>'required|string',
            'feedback'=>'required|string',
        ]);
        
        Submission::create($request->all());
        return redirect()->route('submission.index')->with('success','Submission Created successfully!');
    }
    public function edit($id){
        $submission=Submission::findOrFail($id);
        $assignment=Assignment::all();
        $user=User::all();
        return view('submission.edit',compact('submission','assignment','user'));
    }
    public function update(Request $request , $id){
        $request->validate([
            'assignment_id'=>'required|exists:assignments,id',
            'user_id'=>'required|exists:users,id',
            'submission_date'=>'required|date',
            'grade'=>'required|string',
            'feedback'=>'required|string',
        ]);
        $submission=Submission::findOrFail($id);
        $submission->update($request->all());
        return redirect()->route('submission.index')->with('success','Submission Updated successfully!');
    }
    public function destroy($id){
        $submission=Submission::findOrFail($id);
        $submission->delete();
        return redirect()->route('submission.index')->with('success','Submission Deleted successfully!');
    }
}
