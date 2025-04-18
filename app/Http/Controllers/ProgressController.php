<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index()
{
    $progress = Progress::with('lesson')->orderBy('created_at', 'desc')->get();
    return view('progress.index', compact('progress'));
}

    // Get progress for a specific user
    public function indexApi(Request $request)
    {
        $progress = Progress::where('user_id', $request->user()->id)
                            ->with('lesson') 
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json($progress);
    }

    // Store a new progress entry
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
            'completed' => 'required|boolean',
        ]);

        $progress = Progress::create([
            'user_id' => $request->user_id,
            'lesson_id' => $request->lesson_id,
            'completed' => $request->completed,
            'completed_at' => $request->completed ? now() : null,
        ]);

        return response()->json($progress, 201);
    }

    // Update progress (mark lesson as completed)
    public function update(Request $request, $id)
    {
        $progress = Progress::findOrFail($id);

        $progress->update([
            'completed' => true,
            'completed_at' => now(),
        ]);

        return response()->json(['message' => 'Progress updated successfully']);
    }

    // Delete progress entry
    public function destroy($id)
    {
        $progress = Progress::findOrFail($id);
        $progress->delete();

        return response()->json(['message' => 'Progress deleted']);
    }
}
