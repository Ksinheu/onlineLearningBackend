<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        // $sliders = Slider::all();
        $news = News::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5);

    
    $i = (request()->input('page', 1) - 1) * 5;
        return view('News.index', compact('news'));
    }
    public function create()
    {
        return view('News.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'imageNews' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:20',
        ]);
        $imagePath = $request->file('imageNews')->store('imgNews', 'public');
        News::create([
            'imageNews'=> $imagePath,
    'status' => $validated['status'] ?? 'active',
    ]);
        return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);
        // return redirect()->route('slider.index')->with('success','Image uploaded successfully!');
    }
    public function ApiIndex(){
        // $news = News::all();
         $news = News::where('status', 'active')->get();
        return response()->json([
            'message' => 'News retrieved successfully!',
            'news' => $news
        ]);
    }
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('News.show', compact('news'));
    }
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('News.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
       $validated= $request->validate([
            'imageNews' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|max:20',
        ]);

        $news = News::findOrFail($id);

        if ($request->hasFile('imageNews')) {
            // Delete old image
            if ($news->imageNews) {
                Storage::disk('public')->delete($news->imageNews);
            }

            // Upload new image
            $imagePath = $request->file('imageNews')->store('newImage', 'public');
            $news->update(['imageNews' => $imagePath]);
        }
        // Update status
    $news->status = $validated['status'];
    $news->save();
        return redirect()->route('news.index')->with('success', 'Image updated successfully!');
    }
    public function destroy($id)
    {
        $news = News::findOrFail($id);

          // Delete image from storage (only if exists)
    if ($news->imageNews && Storage::disk('public')->exists($news->imageNews)) {
        Storage::disk('public')->delete($news->imageNews);
    }

        // Delete the record
        $news->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
