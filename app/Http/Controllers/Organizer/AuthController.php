<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. Fungsi menampilkan halaman view formulir
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Fungsi memproses validasi Submit Log In
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (! $user instanceof User || ! in_array($user->role, ['superadmin', 'organizer'], true)) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun Anda tidak memiliki akses ke panel organizer.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('organizer.dashboard'); // Arahkan ke rute dashboard
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'organization_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $slug = Str::slug($data['organization_name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Organization::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $organization = Organization::create([
            'name' => $data['organization_name'],
            'slug' => $slug,
            'status' => 'active',
        ]);

        $user = User::create([
            'organization_id' => $organization->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'organizer',
        ]);

        Auth::login($user);

        return redirect()->route('organizer.dashboard');
    }

    // 3. Fungsi memroses Log Out (Keluar)
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

