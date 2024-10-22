<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            // Fetch Google user details
            $google_user = Socialite::driver('google')->user();
            // Check if the user exists based on Google ID
            $user = User::where('google_id', $google_user->getId())->first();

            // If no user is found, create a new user with a pending status
            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'), // This is temporary, consider generating a secure random password
                    'role' => User::ROLE_STAFF,  // Default to staff role
                    'status' => 'pending',      // Account status pending for approval
                ]);

                return redirect()->route('login')->withErrors(['email' => 'Account is pending approval. Please contact your administrator.']);
            }

            // If the user exists, check their status
            if ($user->status === 'approved') {
                // Log the user in if approved
                Auth::login($user);

                // Redirect based on user role
                switch ($user->role) {
                    case User::ROLE_ADMIN:
                        return redirect()->intended(route('admin.home'));
                    case User::ROLE_SUPERADMIN:
                        return redirect()->intended(route('superadmin.home'));
                    default:
                        return redirect()->intended(route('staff.home'));
                }
            } else {
                // If the user is not approved
                return redirect()->route('login')->withErrors(['email' => 'Your account is not yet approved.']);
            }

        } catch (\Exception $e) {
            // Handle any exceptions during authentication
            return redirect()->route('login')->withErrors(['error' => 'Failed to authenticate with Google. Please try again.']);
        }
    }
}
