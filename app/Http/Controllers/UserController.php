<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SetPasswordMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(){
        $users = User::latest() -> where('status', 'active')->get();
        //$users = DB::table('users') -> where('status', 'inactive')->get();
        //dd($users);
        return view('users.index',[
            'users' => $users
        ]);
    }

    public function create(){
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|array'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');

        // 1. Generate random alphanumeric password
        $temporaryPassword = Str::random(12);

        // 2. Create user with this temporary password
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($temporaryPassword),
            'status' => 'inactive',  // New user starts as inactive
            'phone' => "0785492188",
        ]);

        $user->syncRoles($request->roles);

        // 3. Generate unique token (for password set link)
        $token = Str::random(64);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();  // Clear old token first

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // 4. Send email
        Mail::to($user->email)->send(new SetPasswordMail($user, $token));

        return redirect()->route('users.index')->with('success', 'User created successfully. They will receive an email to set their password.');
    }


    public function edit(User $user){
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('users.edit',[
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|max:255',
            'password_verify' => 'nullable|string|same:password',
            'roles' => 'required|array'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // if(!empty($request->password_verify)){
        //     $data += [
        //         'password' => Hash::make($request->password),
        //     ];
        // }

        // Only update the password if it's provided and verified
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User Update Successfully with roles');
    }


    public function destroy($userId)
    {
        if (auth()->id() == $userId) {
            return redirect()->route('users.index')->with('error', 'You cannot deactivate your own account.');
        }

        $user = User::findOrFail($userId);
        $user->update(['status' => User::STATUS_INACTIVE]);

        return redirect()->route('users.index')->with('success', 'User deactivated successfully.');
    }


    public function inactive()
    {
        $users = User::where('status', User::STATUS_INACTIVE)->get();
        return view('users.inactive', compact('users'));
    }


    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        return redirect()->route('users.inactive')->with('success', 'User restored successfully!');
    }


    public function showSetPasswordForm($id, Request $request)
    {
        $token = $request->query('token');
        return view('auth.set-password', compact('id', 'token'));
    }


    public function setPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $user = User::findOrFail($id);

        // Validate token from DB
        $record = DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
            'status' => 'active',  // Mark as active after setting password
        ]);

        // Clear used token
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('success', 'Password set successfully. You can now login.');
    }





}
