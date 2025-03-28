<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NewsController extends Controller
{
    public function index(){
        $news = News::all();
        return view('News.index',compact('news'));
    }
    public function create(){
        return view('News.create');
    }
    public function store(Request $request){
        $request->validate([
            'imageNews' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('imageNews')->store('newImage', 'public');
        News::create(['imageNews'=> $imagePath]);
        return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);
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
    $request->validate([
        'imageNews' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $news = News::findOrFail($id);

    if ($request->hasFile('imageNews')) {
        // Delete old image
        if ($news->imageNews) {
            Storage::disk('public')->delete($news->imageNews);
        }

        // Upload new image
        $imagePath = $request->file('imageNews')->store('images', 'public');
        $news->update(['imageNews' => $imagePath]);
    }

    return redirect()->route('news.index')->with('success', 'Image updated successfully!');
}
public function destroy($id)
{
    $news = News::findOrFail($id);

    // Delete the image file
    if ($news->imageNews) {
        Storage::disk('public')->delete($news->imageNews);
    }

    // Delete the record
    $news->delete();

    return back()->with('success', 'Image deleted successfully!');
}


    public function ApiIndex(){
        $news = News::all();
        return response()->json([
            'message' => 'News retrieved successfully!',
            'News' => $news
        ]);
    }
}
