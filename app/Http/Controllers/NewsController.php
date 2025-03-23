<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $news = News::all();
        return response()->json([
            'message' => 'Sliders retrieved successfully!',
            'News' => $news
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'imageNews' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('imageNews')->store('images', 'public');
        News::create(['imageNews'=> $imagePath]);
        return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);
    }
}
