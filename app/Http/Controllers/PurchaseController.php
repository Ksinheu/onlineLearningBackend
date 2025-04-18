<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
{
    $payments = Purchase::with('course')->orderBy('purchase_date', 'desc')->get();
    return view('payments.index', compact('payments'));
}
    // Get all payments for a user
    public function indexApi(Request $request)
    {
        $payments = Purchase::where('user_id', $request->user()->id)
                           ->with('course')
                           ->orderBy('purchase_date', 'desc')
                           ->get();

        return response()->json($payments);
    }

    // Store a new payment record
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'payment_status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Purchase::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json($payment, 201);
    }

    // Update payment status
    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Purchase::findOrFail($id);
        $payment->update(['payment_status' => $request->payment_status]);

        return response()->json(['message' => 'Payment status updated successfully']);
    }

    // Delete a payment record
    public function destroy($id)
    {
        $payment = Purchase::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment record deleted']);
    }
}
