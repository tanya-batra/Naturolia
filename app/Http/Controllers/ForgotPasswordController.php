<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;

class ForgotPasswordController extends Controller
{
    // Show the forgot password modal/form
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP and expiry
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP mail
        Mail::to($user->email)->send(new OtpMail($otp));

        // Store email in session for next step
        session(['reset_email' => $user->email]);

        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email.',
        ]);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Invalid email address.']);
        }

        if ($user->otp == $request->otp && Carbon::now()->lt($user->otp_expires_at)) {
            // OTP verified successfully
            session(['reset_email' => $user->email]);
            return response()->json([
                'success' => true,
                'otp_verified' => true,
                'message' => 'OTP verified successfully. You can now reset your password.'
            ]);
        }

        return response()->json([
            'success' => false,
            'otp_verified' => false,
            'message' => 'Invalid or expired OTP.'
        ]);
    }

    // Show reset password page
    public function showResetPasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.forgot.form')->with('error', 'Please verify your OTP first.');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('reset_email');
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start again.'
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('reset_email');

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully!'
        ]);
    }
}

