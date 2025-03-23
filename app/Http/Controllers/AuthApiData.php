<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class AuthApiData extends Controller
{
    public function index(){
        $customers=Customer::all();
        return view('dashboard', compact('customers'));
    }
    public function register(Request $request){
        try {
            $validatedData=$request->validate([
                'username'=>'required|string|max:255',
                'email'=>'required|email|unique:customers',
                'gender'=>'required|string',
                'phone'=>'required|string',
                'password'=>'required|string|min:8',
                'device_type' => 'required|string',
                'operating_system' => 'required|string',
                'browser_name' => 'required|string',
                'browser_version' => 'required|string',
                'screen_resolution' => 'required|string',
                'ip_address' => 'required|ip',
                'location' => 'required|string',
            ]);
            $customer = new Customer([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']) // Hash password directly
            ]);
            $customer->save();
            $userDevice = new Device([
                'customer_id' => $customer->id,
                'device_type' => $validatedData['device_type'],
                'operating_system' => $validatedData['operating_system'],
                'browser_name' => $validatedData['browser_name'],
                'browser_version' => $validatedData['browser_version'],
                'screen_resolution' => $validatedData['screen_resolution'],
                'ip_address' => $validatedData['ip_address'],
                'location' => $validatedData['location'],
                // 'last_used' => Carbon::parse($validatedData['last_used'])->toDateTimeString()
            ]);
            $userDevice->save();
            return response()->json(['message' => 'Customer registered successfully'], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }
    public function login(Request $request)
    {
    try {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        // Retrieve the customer with the provided email
        $customer = Customer::where('email', $validated['email'])
                            ->where('status', 'active') // Ensure account is active
                            ->first();
        // Check if the customer exists and validate the password
        if ($customer && Hash::check($validated['password'], $customer->password)) {
            // Optionally hide sensitive fields in the customer response
            $customer->makeHidden(['password']);

            // Return success response
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
            ], 200);
        }
        // If authentication fails
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials or inactive account'
        ], 401);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Log and handle unexpected errors
        Log::error($e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred. Please try again.'], 500);
    }
    }
    public function logout(Request $request)
{
    try {
        if ($request->user()) {
            $request->user()->tokens()->delete(); // Revoke all user tokens (for Laravel Sanctum or Passport)
            return response()->json([
                'status' => true,
                'message' => 'Logout successful'
            ], 200);
        }
        
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], 401);
        
    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'An unexpected error occurred. Please try again.'
        ], 500);
    }
}

}
