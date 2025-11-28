<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function index()
    {
        // Jika user sudah login, arahkan kembali ke dashboard masing-masing
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/cashier/dashboard');
        }
        
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role dan Redirect
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else if ($role === 'cashier') {
                return redirect()->intended('/cashier/dashboard');
            }
            
            // Jika role tidak dikenali
            return redirect('/');
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}