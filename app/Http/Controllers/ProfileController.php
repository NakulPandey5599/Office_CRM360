<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Get the currently logged-in user
        return view('profile.edit', compact('user'));
    }

   public function update(Request $request)
{
    // Get the currently logged-in NewUser
    $user = auth()->user(); 

    // Validate inputs
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'photo' => ['nullable', 'image', 'max:2048'],
    ]);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos', 'public');
        $validated['photo'] = $path;
    }

    // Update DB record
    $user->update($validated);

    return back()->with('success', 'Profile updated successfully!');
}


}
