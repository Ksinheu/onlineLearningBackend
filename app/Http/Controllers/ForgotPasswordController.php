<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeMailNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
     public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        $otp = rand(100000, 999999);

        // Store OTP in database (you can use password_resets table or custom)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $customer->email],
            [
                'token' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // Send email
        Mail::to($customer->email)->send(new TwoFactorCodeMailNew($otp));

        return response()->json(['message' => 'Reset code sent successfully.'], 200);
    }

    public function loginWithOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:customers,email',
        'otp' => 'required|digits:6'
    ]);

    $record = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->otp)
                ->first();

    if (!$record) {
        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

    // Expiration check (10 minutes)
    if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
        return response()->json(['message' => 'OTP has expired.'], 400);
    }

    // Login user
    $customer = Customer::where('email', $request->email)->first();

    // Delete used OTP
    DB::table('password_resets')->where('email', $request->email)->delete();

    // Create token
    $token = $customer->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'customer' => $customer
    ]);
}
}
