<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PublicAuthController extends Controller
{
    public function showLoginUser()
    {
        return view('auth.customer-auth', ['activeTab' => 'login']);
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (in_array(auth()->user()->role, ['superadmin', 'admin'], true)) {
                return redirect()->route('admin.dashboard');
            }

            if (auth()->user()->role !== 'user') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan End User. Silakan masuk lewat halaman Organizer.',
                ])->withInput();
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau Password tidak cocok.',
        ])->withInput();
    }

    public function showRegisterUser()
    {
        return view('auth.customer-auth', ['activeTab' => 'register']);
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    public function showLoginAdmin()
    {
        return view('auth.admin-login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (! in_array(auth()->user()->role, ['superadmin', 'admin'], true)) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses admin.',
                ])->withInput();
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showLoginOrganizer()
    {
        return view('auth.organizer-login');
    }

    public function loginOrganizer(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (in_array(auth()->user()->role, ['superadmin', 'admin'], true)) {
                return redirect()->route('admin.dashboard');
            }

            if (auth()->user()->role !== 'organizer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan Organizer. Silakan masuk lewat halaman End User.',
                ])->withInput();
            }

            return redirect()->route('organizer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password tidak cocok.',
        ])->withInput();
    }

    public function showRegisterOrganizer()
    {
        return view('auth.organizer-register');
    }

    public function registerOrganizer(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Organization::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $organization = Organization::create([
            'name' => $data['name'],
            'slug' => $slug,
            'status' => 'active',
        ]);

        $user = User::create([
            'organization_id' => $organization->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'organizer',
        ]);

        Auth::login($user);
        return redirect()->route('organizer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
