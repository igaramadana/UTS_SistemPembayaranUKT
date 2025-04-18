<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role->role_code) {
                case 'ADM':
                    session()->flash('notification', [
                        'message' => 'Login Berhasil, Selamat datang di halaman admin',
                        'type' => 'success'
                    ]);
                    return redirect()->route('admin.index');

                default:
                    session()->flash('notification', [
                        'message' => 'Login Berhasil Selamat datang ' . $user->email,
                        'type' => 'success'
                    ]);
                    return redirect()->route('testing');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        showNotification('Logout Berhasil', 'success');
        return redirect()->route('login');
    }
}
