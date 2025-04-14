<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permission = Permission::paginate(10);

        return view('permissions.index', [
            'permissions' => $permission
        ]);
    }

    public function create(){
        return view('permissions.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' =>[
                    'required',
                    'string',
            ]
        ]);

        // Check if the permission already exists
        if (Permission::where('name', $request->name)->where('guard_name', 'web')->exists()) {
            return redirect()->back()->with('error', 'The permission already exists.');
        }

        Permission::create([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission Created Successfully');
    }

}
