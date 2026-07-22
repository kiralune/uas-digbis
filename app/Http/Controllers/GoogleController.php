<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        $request->session()->put('login_redirect', $request->query('redirect_to', route('home')));
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user && $user->role !== 'user') {
            return redirect()->route('login')->with('error', 'Google login hanya untuk end user. Silakan masuk dengan email.');
        }

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'role' => 'user',
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
            ]);
        } else {
            $user->update([
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ]);
        }

        Auth::login($user);

        return redirect($request->session()->pull('login_redirect', route('home')));
    }
}