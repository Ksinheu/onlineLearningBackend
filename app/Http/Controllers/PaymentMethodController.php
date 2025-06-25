<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index(){
        $payment_method=Payment_method::latest()->paginate(5);
        return view('payment_method.index',compact('payment_method'));
    }
 
    public function create(){
        return view('payment_method.create');
    }
    public function store(Request $request){
        $validated=$request->validate([
            'name_bank'=>'required|string',
            'number_bank'=>'required|numeric',
            'QR_code'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number'=>'required|regex:/^[0-9]{9,15}$/',
            'status'=>'required|in:pending,active'
        ]);
          // Store the image in the public disk under imgCourse folder
    $imagePath = $request->file('QR_code')->store('QR_code', 'public');
        Payment_method::create([
            'name_bank'=>$validated['name_bank'],
            'number_bank'=>$validated['number_bank'],
            'QR_code'=>$imagePath,
            'phone_number'=>$validated['phone_number'],
            'status'=>$validated['status']
        ]);
        return back()->with('success', 'Payment method created successfully!')->with('imagePath', $imagePath);
    }
       public function indexApi(){
        // $payment_method=Payment_method::all();
         $payment_method = Payment_method::where('status', 'active')->get();
         // Only return sliders with 'active' status
    // $payment_method = Payment_method::where('status', 'active')->get();
        return response()->json([
            'message'=>'Payment method retrieved scussessfuly!',
            'Payment_method'=>$payment_method
        ]);
    }
    public function show($id)
{
    $payment_method = Payment_method::findOrFail($id);
    return view('payment_method.show', compact('payment_method'));
}
    public function edit($id){
        $payment_method=Payment_method::findOrFail($id);
        return view('payment_method.edit',compact('payment_method'));
    }
    public function update(Request $request, $id)
{
    $payment_method = Payment_method::findOrFail($id);

    $validated = $request->validate([
        'name_bank' => 'required|string',
        'number_bank' => 'required|numeric',
        'QR_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'phone_number' => 'required|regex:/^[0-9]{9,15}$/',
        'status' => 'required|in:pending,active'
    ]);

    // Handle image upload if new image is provided
    if ($request->hasFile('QR_code')) {
        if ($payment_method->QR_code) {
            Storage::disk('public')->delete($payment_method->QR_code);
        }
        $imagePath = $request->file('QR_code')->store('images', 'public');
        $payment_method->QR_code = $imagePath;
    }

    // Update all other fields
    $payment_method->name_bank = $validated['name_bank'];
    $payment_method->number_bank = $validated['number_bank'];
    $payment_method->phone_number = $validated['phone_number'];
    $payment_method->status = $validated['status'];

    $payment_method->save();

    return redirect()->route('payment_method.index')->with('success', 'Payment method updated successfully');
}

    public function destroy($id){
        $payment_method=Payment_method::findOrFail($id);
        // Delete the image file
        if ($payment_method->QR_code) {
            Storage::disk('public')->delete($payment_method->QR_code);
        }
        $payment_method->delete();
        return redirect()->route('payment_method.index')->with('success','Course deleted successfully!');
    }
}
