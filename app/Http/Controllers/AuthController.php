<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");
        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with("error", "Invalid credentials.");
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expiry = Carbon::now()->addMinutes(5);
        $user->save();

        // Send OTP via Email
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)->subject('Your OTP Code');
        });

        Session::put("otp_user_id", $user->id);

        return redirect()->route("show.otp")->with("success", "OTP sent to your email.");
    }

    public function register()
    {
        return view("auth.register");
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
            "phone" => "required",
        ]);

        // Generate a random password
        $generatedPassword = Str::random(8);

        // Create User
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($generatedPassword),
            "set_password_required" => true, // Flag for middleware
        ]);

        // Send Set Password Email
        Mail::send("emails.set-password", ["user" => $user, "password" => $generatedPassword], function ($message) use ($user) {
            $message->to($user->email)->subject("Set Your Password");
        });

        return redirect()->route("login")->with("success", "Check your email to set your password.");
    }

    public function showSetPasswordForm(Request $request)
    {
        return view('auth.set-password', ['email' => $request->email]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->set_password_required = false;
        $user->save();

        return redirect()->route('login')->with('success', 'Password set successfully. You can now log in.');
    }

    public function showOtp()
    {
        return view("auth.otp");
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(["otp" => "required|numeric"]);

        $user = User::find(Session::get("otp_user_id"));

        if (!$user || $user->otp !== $request->otp || Carbon::now()->gt($user->otp_expiry)) {
            return back()->with("error", "Invalid or expired OTP.");
        }

        // Clear OTP and log in user
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();
        Auth::login($user);

        return redirect()->route("dashboard")->with("success", "Login successful!");
    }

    public function resendOtp()
    {
        $user = User::find(Session::get("otp_user_id"));

        if (!$user) {
            return back()->with("error", "User not found.");
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expiry = Carbon::now()->addMinutes(5);
        $user->save();

        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)->subject('Your OTP Code');
        });

        return back()->with("success", "New OTP sent.");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
