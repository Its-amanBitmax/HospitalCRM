<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Mail\OtpMail;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function sendOTP(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:admins,email']);

        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'otp_email' => $request->email, 'otp_expires' => now()->addMinutes(10)]);

        try {
            Mail::to($request->email)->send(new OtpMail($otp));
            return response()->json(['message' => 'OTP sent to your email.']);
        } catch (\Exception $e) {
            // Log the OTP for testing if mail fails
            \Log::info("OTP for {$request->email}: $otp (Mail failed: " . $e->getMessage() . ")");
            return response()->json(['message' => 'OTP generated. Check server logs if email not received.']);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        if (session('otp') != $request->otp || now()->greaterThan(session('otp_expires'))) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 400);
        }

        session(['otp_verified' => true]);

        return response()->json(['message' => 'OTP verified.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        if (!session('otp_verified') || session('otp_email') != $request->email) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $admin = Admin::where('email', session('otp_email'))->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        session()->forget(['otp', 'otp_email', 'otp_expires', 'otp_verified']);

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
