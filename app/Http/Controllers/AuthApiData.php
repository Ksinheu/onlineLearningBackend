<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthApiData extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $today = Carbon::today();
        $count = Customer::whereDate('created_at', $today)->count();
        $countAll = Customer::all()->count();
        $completedPurchases = Purchase::where('payment_status', 'completed')->get();

        // Sum the prices of related courses
        $totalIncome = $completedPurchases->sum(function ($purchase) {
            return $purchase->course->price ?? 0; // Avoid error if course is null
        });
        // Count students who completed payment
        $paidStudentCount = Purchase::where('payment_status', 'completed')
                                    ->distinct('customer_id')
                                    ->count('customer_id');
        return view('dashboard', compact('customers', 'count', 'countAll','totalIncome','paidStudentCount'));
    }
    public function indexApi()
    {
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
                    'customer' => $customer, // 👈 this gives the frontend all it needs
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

public function show($id)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json(['error' => 'Customer not found'], 404);
    }

    return response()->json([
        'id' => $customer->id,
        'username' => $customer->username,
        'email' => $customer->email,
        'phone' => $customer->phone,
        'gender' => $customer->gender
    ]);
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
                ], 200)->header('Content-Type', 'application/json; charset=utf-8');
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

    // Add this function before the closing brace of the class
    public function uploadPaySlip(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'customer_id' => 'required|exists:customers,id',
                'pay_slip' => 'required|string',
                'purchase_date' => 'required|date',
                'payment_status' => 'required|string|in:pending,completed,failed'
            ]);
            $customers = $request->user();
            $course = $request->course();
            if (!$customers || !$course) {
                return response()->json([
                    'error' => 'Unauthorized'
                ], 401);
            }

            // Handle file upload
            $file = $request->file('pay_slip');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payments', $filename);

            // Create or update purchase record
            $purchase = Purchase::updateOrCreate(
                [
                    'customer_id' => $customers->id,
                    'course_id' => $course->id
                ],
                [
                    'pay_slip' => $path,
                    'purchase_date' => $validated['purchase_date'],
                    'payment_status' => $validated['payment_status']
                ]
            );
// Dispatch the event here
event(new \App\Events\PaySlipUploaded($purchase));

            return response()->json([
                'success' => true,
                'message' => 'Payment slip uploaded successfully',
                'purchase' => $purchase
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment upload error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while processing your payment',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:customers,email',
        'token' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $resetRecord = DB::table('password_resets')->where('email', $request->email)->first();

    if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
        return response()->json(['error' => 'Invalid or expired token'], 400);
    }

    Customer::where('email', $request->email)->update([
        'password' => Hash::make($request->password),
    ]);

    DB::table('password_resets')->where('email', $request->email)->delete();

    return response()->json(['message' => 'Password has been reset successfully']);
}

}
