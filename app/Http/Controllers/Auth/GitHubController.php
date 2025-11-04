<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Unable to login using GitHub.');
        }

        // Try to find user by GitHub ID first
        $user = User::where('github_id', $githubUser->id)->first();

        if (!$user) {
            // Then check by email
            $user = User::where('email', $githubUser->email)->first();

            if ($user) {
                // Update existing user to link GitHub ID
                $user->update(['github_id' => $githubUser->id]);
            } else {
                // Create a new user with GitHub data
                $user = User::create([
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email,
                    'github_id' => $githubUser->id,
                    'password' => Hash::make(uniqid()), // dummy password
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }
}
