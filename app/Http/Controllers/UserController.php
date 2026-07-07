<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all system users
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Save a new guard/admin profile
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guard'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Securely hash passwords
            'role' => $data['role']
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,guard'
    ]);

    // Explicitly update the data structure row column parameters
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role']
    ]);

    return redirect()->back()->with('success', 'User clearance level updated successfully!');
}

}

