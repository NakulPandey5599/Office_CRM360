<?php

namespace App\Http\Controllers;

use App\Models\NewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = NewUser::all(); // fetch all users
        return view('admin.dashboard', compact('users'));
    }

    public function show()
    {  
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:new_users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $formFields['password'] = Hash::make($formFields['password']);

        NewUser::create($formFields);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully!');
    }

    public function delete($id)
    {
        $user = NewUser::findOrFail($id);

        // Delete photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully!');
    }

    public function edit($id)
    {
        $user = NewUser::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = NewUser::findOrFail($id);

        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'required|email|unique:new_users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $formFields['photo'] = $request->file('photo')->store('photos', 'public');
        }

       // Handle password
        if ($request->filled('password')) {
            $formFields['password'] = Hash::make($request->password);
        } else {
            unset($formFields['password']);
        }

        $user->update($formFields);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
    }
}
