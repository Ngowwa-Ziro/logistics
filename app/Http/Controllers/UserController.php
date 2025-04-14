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
    public function index()
    {
        $users = User::latest() -> where('status', 'active')->paginate(10);

        return view('users.index',[
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|array',
            'phone' => 'nullable|numeric|digits_between:9,12'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone',);


        if ($phone) {
            // Remove non-numeric characters
            $phone = preg_replace('/\D/', '', $phone);

            // If the phone starts with 0, replace it with 254
            if (substr($phone, 0, 1) === '0') {
                $phone = '254' . substr($phone, 1);
            } elseif (substr($phone, 0, 3) !== '254') {
                $phone = '254' . $phone;
            }
        }

        $temporaryPassword = Str::random(12);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($temporaryPassword),
            'status' => 'inactive',
            'phone' => $phone,
        ]);


        $user->syncRoles($request->roles);
        $token = Str::random(64);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => bcrypt($token),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(60),
        ]);


        Mail::to($user->email)->send(new SetPasswordMail($user, $token));

        return redirect()->route('users.index')->with('success', 'User created successfully. They will receive an email to set their password.');
    }




    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('users.edit',[
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|',
            'phone' => 'nullable|numeric|digits_between:9,12',
            'password' => 'nullable|string|min:8|max:255',
            'password_verify' => 'nullable|string|same:password',
            'roles' => 'required|array'
        ]);

        //dd($request);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->name
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

    // public function destroy($id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return redirect()->route('users.index')->with('error', 'User not found.');
    //     }

    //     $user->delete();

    //     return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    // }



    public function inactive()
    {
        $users = User::where('status', User::STATUS_INACTIVE)->paginate(10);

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
        // dd($request -> all());
        $request->validate([
            'password' => 'required|min:8'

        ]);
        //dd($request);

        $user = User::findOrFail($id);
        //dd($user);

        // Validate token from DB
        $record = DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->first();
                 //   dd($record);


        if (!$record ) {
            return back()->withErrors(['token' => 'Invalid or expired token.']);
        }

        // Check if the token has expired
        if (now()->greaterThan($record->expires_at)) {
            //dd($record);
            return back()->withErrors(['token' => 'This reset token has expired.']);
        }


        $user->update([
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);
        // dd($user);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('success', 'Password set successfully. You can now login.');
    }

}
