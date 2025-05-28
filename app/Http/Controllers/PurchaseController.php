<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

class PurchaseController extends Controller
{
public function index()
{
    return Purchase::with(['customer', 'course'])->orderBy('created_at', 'desc')->get();
}
// public function store(Request $request)
// {
//     $request->validate([
//         'customer_id' => 'required|exists:customers,id',
//         'course_id' => 'required|exists:courses,id',
//         'pay_slip' => 'required|image|mimes:jpg,jpeg,png|max:2048',
//     ]);
// // Store image in 'public/pay_slips'
// $paySlipPath = $request->file('pay_slip')->store('pay_slips', 'public');
//     $payment = Purchase::create([
//         'customer_id' => $request->customer_id,
//         'course_id' => $request->course_id,
//         'pay_slip' => $paySlipPath,
//         'payment_status' => 'pending',
//     ]);
//     Livewire::emit('paymentSubmitted');
//     return response()->json(['message' => 'Payment created successfully', 'payment' => $payment], 201);
// }
// public function store(Request $request)
// {
//     // Validate input
//     $request->validate([
//         'customer_id' => 'required|exists:customers,id',
//         'course_id' => 'required|exists:courses,id',
//         'pay_slip' => 'required|string',
//     ], [
//         'pay_slip.required' => 'A payment slip image is required.',
//         'pay_slip.image' => 'The payment slip must be an image (jpg, jpeg, or png).',
//         'pay_slip.max' => 'The payment slip must not exceed 2MB.',
//     ]);

//     // Check authorization
//     if (auth()->id() !== $request->customer_id) {
//         return response()->json(['error' => 'Unauthorized'], 403);
//     }

//     try {
//         // Store file with unique name
//         $fileName = time() . '_' . $request->file('pay_slip')->getClientOriginalName();
//         $paySlipPath = $request->file('pay_slip')->storeAs('pay_slips', $fileName, 'public');

//         // Create purchase in transaction
//         $payment = DB::transaction(function () use ($request, $paySlipPath) {
//             return Purchase::create([
//                 'customer_id' => $request->customer_id,
//                 'course_id' => $request->course_id,
//                 'pay_slip' => $paySlipPath,
//                 'payment_status' => 'pending',
//             ]);
//         });

//         // Emit Livewire event
//         Livewire::emit('paymentSubmitted');

//         // Return standardized response
//         return response()->json([
//             'status' => 'success',
//             'message' => 'Payment created successfully',
//             'data' => ['payment' => $payment],
//         ], 201);
//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => 'error',
//             'message' => 'Failed to process payment',
//         ], 500);
//     }
// }

// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'customer_id' => 'required|exists:customers,id',
//         'course_id' => 'required|exists:courses,id',
//         'pay_slip' => 'required|string'
//     ]);

//     // Decode base64 image and save
//     $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $validated['pay_slip']);
//     $imageName = uniqid() . '.png';
//     $imagePath = storage_path('app/public/slips/' . $imageName);
//     file_put_contents($imagePath, base64_decode($base64));

//     // Save payment record
//     Purchase::create([
//         'customer_id' => $validated['customer_id'],
//         'course_id' => $validated['course_id'],
//         'pay_slip' => 'slips/' . $imageName,
//         'payment_status' => 'pending', // optional; default is already pending
//     ]);

//     return response()->json(['message' => 'Purchase successful']);
// }
public function store(Request $request) {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'course_id' => 'required|exists:courses,id',
                'pay_slip' => 'required|string'
            ]);

            $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $validated['pay_slip']);
            $imageName = uniqid() . '.png';
            $imagePath = storage_path('app/public/slips/' . $imageName);
            file_put_contents($imagePath, base64_decode($base64));

            Purchase::create([
                'customer_id' => $validated['customer_id'],
                'course_id' => $validated['course_id'],
                'pay_slip' => 'slips/' . $imageName,
                'payment_status' => 'pending'
            ]);

            return response()->json(['message' => 'Purchase successful']);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
public function approve($id) {
    $purchase = Purchase::findOrFail($id);
    $purchase->update(['payment_status' => 'approved']);
    // Grant lesson access (e.g., attach course to user)
    $purchase->customer->courses()->attach($purchase->course_id);
    return response()->json(['message' => 'Purchase approved, lesson access granted']);
}
public function show($id)
{
    $payment = Purchase::with(['customer', 'course'])->findOrFail($id);
    return $payment;
}
public function update(Request $request, $id)
{
    $payment = Purchase::findOrFail($id);

    $request->validate([
        'payment_status' => 'required|in:pending,completed,failed',
    ]);

    $payment->update($request->only('payment_status'));

    // If approved, enroll the customer in the course
    if ($request->payment_status === 'completed') {
        DB::table('customer_course')->updateOrInsert(
            [
                'customer_id' => $payment->customer_id,
                'course_id' => $payment->course_id,
            ],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }

    return response()->json(['message' => 'Payment updated successfully']);
}

public function destroy($id)
{
    $payment = Purchase::findOrFail($id);
    $payment->delete();

    return response()->json(['message' => 'Payment deleted successfully']);
}
}
