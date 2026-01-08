<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    /**
     * Update email
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'required|string',
        ]);

        // Verify current password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password tidak valid',
            ], 400);
        }

        $user->update(['email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diperbarui!',
        ]);
    }

    /**
     * Update language preference
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:id,en',
        ]);

        Auth::user()->update(['language' => $request->language]);

        return response()->json([
            'success' => true,
            'message' => 'Bahasa berhasil diperbarui!',
        ]);
    }

    /**
     * Update privacy settings
     */
    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'is_profile_hidden' => 'boolean',
        ]);

        Auth::user()->update([
            'is_profile_hidden' => $request->boolean('is_profile_hidden'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan privasi berhasil diperbarui!',
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini tidak valid',
            ], 400);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui!',
        ]);
    }
}
