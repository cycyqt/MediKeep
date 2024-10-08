<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdmin_dashboard extends Controller
{
    public function home()
    {
        $totalUsers = User::count();
        return view('superadmin.home', compact('totalUsers'));
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();
        $archivedUsers = User::onlyTrashed()->orderBy('created_at', 'DESC')->get();
        return view('superadmin.users.index', compact('users', 'archivedUsers'));
    }

    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('superadmin.users.show', compact('user'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'role' => 'required|integer|in:1,2,3',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:4|confirmed',
            'role' => 'required|integer|in:1,2,3',
            'status' => 'required|string|in:pending,approved,rejected',
        ]);
    
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User  updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User archived successfully.');
    }
        
    public function destroyForever($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
    
        return redirect()->route('users.index')->with('success', 'User permanently deleted.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        $user->status = 'pending';
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User restored and moved to pending status successfully.');
    }
}
