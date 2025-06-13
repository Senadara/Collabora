<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    // Tampilkan form login
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('page.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // amankan session baru
            return redirect()->intended('/dashboard')->with('success', 'Berhasil login');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout');
    }

    // Tampilkan form register
    public function create()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('page.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:accounts',
            'password' => 'required|confirmed|min:6'
        ]);

        $account = Account::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => 'user',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($account);

        return redirect('/dashboard')->with('success', 'Registrasi dan login berhasil');
    }
}
