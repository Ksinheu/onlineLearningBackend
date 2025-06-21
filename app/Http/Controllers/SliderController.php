<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SliderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        // $sliders = Slider::all();
        $sliders = Slider::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(5);

    
    $i = (request()->input('page', 1) - 1) * 5;
        return view('slider.index',compact('sliders'));
    }
    public function create(){
        return view('slider.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'required|string|max:20',
    ]);

    // Upload and store the image
    $imagePath = $request->file('image')->store('images', 'public');

    // Create new slider
    Slider::create([
        'image' => $imagePath,
        'status' => $validated['status'],
    ]);

    return redirect()->route('slider.index')->with('success', 'Slider created successfully!');
}

    public function ApiIndex()
{
    // Only return sliders with 'active' status
    $sliders = Slider::where('status', 'active')->get();

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
    $validated = $request->validate([
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'status' => 'required|string|max:20',
    ]);

    $slider = Slider::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        // Upload new image
        $imagePath = $request->file('image')->store('images', 'public');
        $slider->image = $imagePath;
    }

    // Update status
    $slider->status = $validated['status'];
    $slider->save();

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
