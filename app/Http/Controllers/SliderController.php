<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return response()->json([
            'message' => 'Sliders retrieved successfully!',
            'sliders' => $sliders
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('image')->store('images', 'public');
        Slider::create(['image'=> $imagePath]);
        return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);
    }
    
}
