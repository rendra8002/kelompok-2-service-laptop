<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('loginError', 'Email atau password salah')->withInput();
        }

        // Cek status setelah login
        $user = Auth::user();
        if ($user->status !== 'active') {
            Auth::logout();
            return back()->with('loginError', 'Akun Anda tidak aktif');
        }

        // Update last login
        \App\Models\User::where('id', $user->id)->update(['last_login_at' => now()]);

        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
