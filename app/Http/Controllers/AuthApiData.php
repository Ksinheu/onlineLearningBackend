<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class AuthApiData extends Controller
{
    public function index(){
        $customers=Customer::all();
         $today = Carbon::today();
        $count = Customer::whereDate('created_at', $today)->count();
        $countAll=Customer::all()->count();
          // Get all completed purchases
    // $completedPurchases = Purchase::where('payment_status', 'completed')->get();

    // Sum the prices of related courses
    // $totalIncome = $completedPurchases->sum(function ($purchase) {
    //     return $purchase->course->price ?? 0; // Avoid error if course is null
    // });
     // Count students who completed payment
    // $paidStudentCount = Purchase::where('payment_status', 'completed')
    //                             ->distinct('customer_id')
    //                             ->count('customer_id');
        return view('dashboard', compact('customers','count','countAll'));
    }
    public function indexApi(){
        $customers = Customer::all();
    return response()->json([
        'success' => true,
        'data' => $customers,
    ], 200);
    }


public function register(Request $request)
{
    try {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'gender' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string|min:8',
            'device_type' => 'required|string',
            'operating_system' => 'required|string',
            'browser_name' => 'required|string',
            'browser_version' => 'required|string',
            'screen_resolution' => 'required|string',
            'ip_address' => 'required|ip',
            'location' => 'required|string',
        ]);

        $customer = Customer::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'status' => 'active', // Set default status
        ]);

        $customer->devices()->create([
            'device_type' => $validatedData['device_type'],
            'operating_system' => $validatedData['operating_system'],
            'browser_name' => $validatedData['browser_name'],
            'browser_version' => $validatedData['browser_version'],
            'screen_resolution' => $validatedData['screen_resolution'],
            'ip_address' => $validatedData['ip_address'],
            'location' => $validatedData['location'],
        ]);

        return response()->json(['message' => 'Customer registered successfully'], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Register error: ' . $e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
    }
}

public function login(Request $request)
{
    try {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $customer = Customer::where('email', $validated['email'])
                            ->where('status', 'active')
                            ->first();

        if ($customer && Hash::check($validated['password'], $customer->password)) {
            $token = $customer->createToken('auth_token')->plainTextToken;

            $customer->makeHidden(['password']);

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                // 'user' => $customer
                'user' => [
            'username' => $customer->username, // 👈 Return the username
            'email' => $customer->email,
            'id' => $customer->id,
        ],
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials or inactive account'
        ], 401);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json([
            'error' => 'Exception: ' . $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
}


public function logout(Request $request)
{
    try {
        $user = $request->user();  // Ensure the user is authenticated

        if ($user) {
            // Revoke all tokens for the authenticated user
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out'
            ],200)->header('Content-Type', 'application/json; charset=utf-8');            
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred during logout.'], 500);
    }
}
    /**
     * Upload a pay slip and create a payment record.
     */
    public function uploadPaySlip(Request $request)
    {
        // Validate input
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'course_id' => 'required|exists:courses,id',
            'pay_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle file upload
        $paySlipPath = $request->file('pay_slip')->store('pay_slips', 'public');

        // Create the payment record
        $payment = Purchase::create([
            'customer_id' => $request->customer_id,
            'course_id' => $request->course_id,
            'pay_slip' => $paySlipPath,
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment submitted successfully.',
            'payment' => $payment
        ], 201);
}

}
