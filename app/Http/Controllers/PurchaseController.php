<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $payments = Purchase::with(['customer', 'course'])
        ->when($search, function ($query, $search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Fetch customers and courses for the create modal
    $customers = Customer::all();
    $courses = Course::all();
    return view('payment.index', compact('payments', 'customers', 'courses'));
}
    public function create()
    {
        $customers = Customer::all();
        $courses = Course::all();
        return view('payment.create', compact('customers', 'courses'));
    }

   public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'course_id' => 'required|exists:courses,id',
        'pay_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'payment_status' => 'required|in:pending,completed,failed',
    ]);

    $path = $request->file('pay_slip')->store('payslips', 'public');
    
    $purchase = Purchase::create([
        'customer_id' => $request->customer_id,
        'course_id' => $request->course_id,
        'pay_slip' => $path,
        'payment_status' => $request->payment_status,
    ]);
    // event(new NewPaymentNotification($purchase)); 
     // Load related models
    $customer = Customer::find($request->customer_id);
    $course = Course::find($request->course_id);
    //  Send Telegram Notification
    $token = '7656164245:AAHru3x35rIVFfkd_Xx5e7tT83weu1kWIDA';
    $chat_id = '-4849538103';
    // $text = "សាកល្បង" . now();
     // Format Telegram Message
    $text = "<b>📢 មានការទូទាត់ថ្មី</b>\n";
    $text .= "👤 ឈ្មោះអ្ន​កទូទាត់: <b>{$customer->username}</b>\n";
    $text .= "📚 មុខវិជ្ជា: <b>{$course->course_name}</b>\n";
    $text .= "🕐 ម៉ោង: " . now()->format('Y-m-d H:i') . "\n";
    // $text .= "🖼️ រូបភាពមុខវិជ្ជា:\n";
    // $text .= "http://localhost:8000/storage/{$course->imgCourse}";
    Http::get("https://api.telegram.org/bot{$token}/sendMessage", [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML',
    ]);

    return response()->json([
        'message' => 'Payment recorded successfully!',
        'data' => $purchase
    ], 201);
}

public function show(Purchase $payment)
{
    return view('payment.show', compact('payment'));
}

    public function edit($id)
    {
        $payment = Purchase::findOrFail($id);
        $customers = Customer::all();
        $courses = Course::all();
        return view('payment.edit', compact('payment', 'customers', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $payment = Purchase::findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'course_id' => 'required|exists:courses,id',
            'pay_slip' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment_status' => 'required|in:pending,completed,failed',
        ]);

        $data = $request->only('customer_id', 'course_id', 'payment_status');

        if ($request->hasFile('pay_slip')) {
            Storage::disk('public')->delete($payment->pay_slip);
            $data['pay_slip'] = $request->file('pay_slip')->store('payslips', 'public');
        }

        $payment->update($data);

        return redirect()->route('payment.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy($id)
    {
        $payment = Purchase::findOrFail($id);
        Storage::disk('public')->delete($payment->pay_slip);
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'Payment deleted successfully!');
    }

    public function getCompletedCourses(Request $request)
{
    $customerId = $request->query('customer_id'); // Get customer_id from query

    $courses = Purchase::with('course')
        ->where('customer_id', $customerId)
        ->where('payment_status', 'completed')
        ->get()
        ->pluck('course') // Extract only course info
        ->unique('id')     // Optional: prevent duplicate courses
        ->values();        // Reindex array

    return response()->json([
        'courses' => $courses
    ]);
}
}
