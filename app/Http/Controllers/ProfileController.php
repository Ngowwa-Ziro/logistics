<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        // Directly update the database without using Eloquent
        DB::table('users')->where('id', Auth::id())->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'updated_at' => now(),
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

}
