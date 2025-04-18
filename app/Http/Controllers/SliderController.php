<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('slider.index',compact('sliders'));
    }
    public function create(){
        return view('slider.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string|max:20',
        ]);
        $imagePath = $request->file('image')->store('images', 'public');
        Slider::create([
            'image'=> $imagePath,
            'status' => $validated['status'] ?? 'active',
        ]);
        return back()->with('success', 'Image uploaded successfully!')->with('imagePath', $imagePath);
        // return redirect()->route('slider.index')->with('success','Image uploaded successfully!');
    }
    public function ApiIndex(){
        $sliders = Slider::all();
        return response()->json([
            'message' => 'Sliders retrieved successfully!',
            'sliders' => $sliders
        ]);
    }
    public function show($id)
{
    $slider = Slider::findOrFail($id);
    return view('slider.show', compact('slider'));
}
    public function edit($id)
{
    $slider = Slider::findOrFail($id);
    return view('slider.edit', compact('slider'));
}

public function update(Request $request, $id)
{
    $validated=$request->validate([
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'nullable|string|max:20',
    ]);

    $slider = Slider::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        // Upload new image
        $imagePath = $request->file('image')->store('images', 'public');
        $slider->update(['image' => $imagePath]);
    }
    

    return redirect()->route('slider.index')->with('success', 'Image updated successfully!');
}
public function destroy($id)
{
    $slider = Slider::findOrFail($id);

    // Delete the image file
    if ($slider->image) {
        Storage::disk('public')->delete($slider->image);
    }

    // Delete the record
    $slider->delete();

    return back()->with('success', 'Image deleted successfully!');
}

}
