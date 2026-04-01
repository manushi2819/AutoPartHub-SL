<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class ForgotPasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('Frontend.auth.forgot-password');
    }

    public function showVerifyForm()
    {
        return view('Frontend.auth.verify-otp');
    }

    public function showResetForm()
    {
        return view('Frontend.auth.reset-password');
    }

    // ✅ Send OTP (stored in session)
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->with('error', 'Email not found');
        }

        $otp = rand(100000, 999999);

        // Store in session
        session([
            'reset_email' => $request->email,
            'reset_otp' => $otp,
            'otp_expiry' => now()->addMinutes(5)
        ]);

        // Send email
        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset OTP');
        });

        return redirect()->route('verify.otp')
            ->with('success', 'OTP sent to your email');
    }

    // ✅ Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if (!session('reset_otp')) {
            return redirect()->route('forgot.password')
                ->with('error', 'Session expired. Try again.');
        }

        if (now()->gt(session('otp_expiry'))) {
            return redirect()->route('forgot.password')
                ->with('error', 'OTP expired.');
        }

        if ($request->otp != session('reset_otp')) {
            return back()->with('error', 'Invalid OTP');
        }

        return redirect()->route('reset.password');
    }

    // ✅ Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('forgot.password')
                ->with('error', 'Session expired');
        }

        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return redirect()->route('forgot.password');
        }

        $customer->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear session
        session()->forget(['reset_email', 'reset_otp', 'otp_expiry']);

        return redirect()->route('Frontend.login')
            ->with('success', 'Password reset successful');
    }
}