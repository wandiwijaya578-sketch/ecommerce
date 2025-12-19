<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;                    // <-- PENTING: Import ini
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login (default fallback).
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Override redirect setelah login berhasil
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        // Cek apakah user adalah admin
        // Sesuaikan kondisi ini dengan kolom di tabel users kamu
        if ($user->role === 'admin' || ($user->is_admin ?? false)) {
            return redirect('/admin/dashboard'); // atau route('admin.dashboard')
        }

        // User biasa
        return redirect('/home'); // atau route('home')
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}