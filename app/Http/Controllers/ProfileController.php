<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $profile = Auth::user()->profile;
        return view('profile.index', compact('profile'));
    }

    /**
     * Store a newly created profile (if deleted/none exists).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->profile) {
            return redirect()->route('profile.index')->with('error', 'Profile already exists.');
        }

        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'date_of_birth' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'biography' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $validatedData['profile_photo'] = $path;
        }

        $validatedData['user_id'] = $user->id;
        Profile::create($validatedData);

        // Update User Name as well
        $user->update(['name' => $request->full_name]);

        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $profile = Auth::user()->profile;
        if (!$profile) {
            return redirect()->route('profile.index')->with('error', 'No profile to update.');
        }

        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'date_of_birth' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'biography' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'github' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $validatedData['profile_photo'] = $path;
        }

        $profile->update($validatedData);

        // Sync with User Name
        Auth::user()->update(['name' => $request->full_name]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy()
    {
        $profile = Auth::user()->profile;
        if ($profile) {
            // Delete photo
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $profile->delete();
            return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
        }
        return redirect()->route('profile.index')->with('error', 'Profile not found.');
    }
}
