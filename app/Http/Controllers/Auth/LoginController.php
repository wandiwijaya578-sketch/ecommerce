<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect setelah LOGIN
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        if ($user->role === 'admin' || ($user->is_admin ?? false)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    /**
     * ⬅️ INI KUNCI UTAMA
     * Redirect SETELAH LOGOUT
     */
    protected function loggedOut(Request $request): RedirectResponse
    {
        return redirect()->route('login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
