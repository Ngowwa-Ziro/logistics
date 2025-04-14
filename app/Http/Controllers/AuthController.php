<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            "email" => "required|email",
            "password" => "required"
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the logged-in user

            // Check user status
            if ($user->status !== 'active') {
                Auth::logout(); // Immediately log them out if inactive
                return back()->with("error", "Your account is not active. Please contact support.");
            }

            // If active, generate OTP
            $otp = rand(100000, 999999);

            // Store OTP in database
            Otp::updateOrCreate(
                ['email' => $user->email],
                ['otp' => $otp, 'created_at' => Carbon::now()]
            );

            // Send OTP via email
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)->subject("Your OTP Code");
            });

            return redirect()->route('show.otp', ['email' => $user->email]);
        }

        return back()->with("error", "Login failed. Please check your credentials.");
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

    public function showOtp(Request $request)
    {
        $email = $request->email;
        return view('auth.otp', compact('email'));
    }



    public function verifyOtp(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "otp" => "required|digits:6"
        ]);

        $otpRecord = Otp::where("email", $request->email)
            ->where("otp", $request->otp)
            ->where("created_at", ">", Carbon::now()->subMinutes(5))
            ->first();

        if ($otpRecord) {
            // Get the user by email
            $user = User::where("email", $request->email)->first();

            if (!$user) {
                return back()->with("error", "User not found.");
            }

            // Log in the user
            Auth::login($user);

            // Redirect based on role
            if ($user->hasRole("admin")) {
                return redirect()->route("admin.dashboard")->with("success", "Login successful!");
            } elseif ($user->hasRole("driver")) {
                return redirect()->route("driver.dashboard")->with("success", "Login successful!");
            } elseif ($user->hasRole("customer")) {
                return redirect()->route("customer.dashboard")->with("success", "Login successful!");
            }elseif ($user->hasRole("super-admin")) {
                return redirect()->route("super-admin.dashboard")->with("success", "Login successful!");
            }

            // Default fallback
            return redirect()->route("dashboard")->with("success", "Login successful!");
        }

        return back()->with("error", "Invalid or expired OTP");
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
