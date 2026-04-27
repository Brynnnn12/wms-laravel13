<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Diperbaiki
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function google_redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback(): RedirectResponse
    {

        try {
            /** @var SocialiteUser $googleUser */
            $googleUser = Socialite::driver('google')->user();


            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'password' => Hash::make(uniqid()), // Set password random karena user login via Google
            ]);

            // dd($user);

            Auth::login($user);
            request()->session()->regenerate();

            toast('Berhasil login dengan Google!', 'success');
            return redirect()->intended('/dashboard');

        } catch (Exception $e) {
            Log::error('Google Register Error: ' . $e->getMessage());

            toast('Gagal login dengan Google. Silakan coba lagi.', 'error');
            return redirect()->route('login');
        }
    }
}
