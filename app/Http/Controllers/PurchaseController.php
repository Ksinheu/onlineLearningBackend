<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

class PurchaseController extends Controller
{
public function index()
{
    return Purchase::with(['customer', 'course'])->orderBy('created_at', 'desc')->get();
}
 public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'course_id' => 'required|exists:courses,id',
            'pay_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
          if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $path = $request->file('pay_slip')->store('payslips', 'public');

       $payment= Purchase::create([
            'customer_id' => $request->customer_id,
            'course_id' => $request->course_id,
            'pay_slip' => $path,
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Payslip uploaded successfully!',
            'data' => $payment
        ], 201);

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
