<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

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

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                toast('Akun belum terdaftar.', 'error');
                return redirect()->route('login');
            }

            $user->update([
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'name' => $googleUser->name,
            ]);

            Auth::login($user);
            request()->session()->regenerate();

            toast('Login Google berhasil!', 'success');

            return redirect('/dashboard');

        } catch (Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());

            toast('Gagal login Google.', 'error');

            return redirect()->route('login');
        }
    }
}
