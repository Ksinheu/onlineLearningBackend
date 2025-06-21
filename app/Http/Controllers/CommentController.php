<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Customer;
use Illuminate\Http\Request;

class CommentController extends Controller
{
     // Display a listing of the comments
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('comments.index', compact('comments'));
    }

    // Show the form for creating a new comment
    public function create()
    {
        return view('comments.create');
    }

    // Store a newly created comment in storage (returns JSON)
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'customer_id' => 'required|exists:customers,id',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create([
            'course_id' => $request->course_id,
            'customer_id' => $request->customer_id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Comment submitted successfully.',
            'data' => $comment
        ], 201);
    }

    // Display the specified comment
    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    // Show the form for editing the specified comment
    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    // Update the specified comment in storage
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required|string',
            'read_status' => 'required|in:pending,active',
        ]);

        $comment->update($request->only('comment', 'read_status'));

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully.');
    }

    // Remove the specified comment from storage
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}
