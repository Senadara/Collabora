<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PharIo\Manifest\Email;

// use Illuminate\Support\Facades\Hash;


class SessionController extends Controller
{
    //Menampilkan form login
    function index()
    {
        $account = Account::all();
        return view('page/login', ['accountList' => $account]);
    }

    // Fungsional Login
    function masuk(Request $request)
    {
        try {
            Session::flash('email', $request->email);
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // $data = Account::where('email', $request->email)->firstOrFail();
            $data = Account::where('email', $request->email)->first();
            if (!$data) {
                return redirect('/account')->withErrors(['error' => 'Email tidak ditemukan']);
            }

            
            if (Hash::check($request->password, $data->password)) {
                session(['account' => $data]);
                return redirect('/dashboard')->with('success', 'berhasil login');
            } else {
                return redirect('/account')->withErrors('Email dan Password yang dimasukkan tidak valid');
            }
        }finally{

        }

    }
    function login(Request $request)
    {
        if (session()->has('account')) {
            session()->pull('account');
        }
        return redirect('/dashboard');
    }

    // Fungsional Logout
    public function logout()
    {
        if (session()->has('account')) {
            session()->flush();
        }
        return redirect('/')->with('success', 'Berhasil Logout');
    }

    //Menampilkan form register
    function create()
    {
        return view("page/register");
    }

    // Fungsional Register
    function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:accounts',
                'password' => 'required|confirmed|min:6'
            ]);
        
            // Create user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'user';
            $user->password = Hash::make($request->password);
            $user->save();
        
            return redirect('/login')->with('success', 'Registrasi berhasil!');

            
        } catch (\Exception $e) {
            return redirect('/register')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}