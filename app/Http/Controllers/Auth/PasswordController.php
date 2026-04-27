<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
  public function update(Request $request): RedirectResponse
{
    $rules = [
        'password' => ['required', Password::defaults(), 'confirmed'],
    ];

    $isGoogleUser = (bool) $request->user()->google_id;

    if (!$isGoogleUser) {
        $rules['current_password'] = ['required', 'current_password'];
    }

    // PAKAI VALIDATE BIASA (Jangan pakai validateWithBag)
    $validated = $request->validate($rules);

    $request->user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    // Berikan session success
    toast('Password berhasil diperbarui!', 'success');

    return back();
}
}
