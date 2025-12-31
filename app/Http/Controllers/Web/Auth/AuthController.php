<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('products.index');
        }

        return view('auth.login');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear all cookies
        foreach ($request->cookies->keys() as $cookieName) {
            cookie()->queue(cookie()->forget($cookieName));
        }
        
        return redirect()->route('login');
    }

    public function resetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function register()
    {
        return view('auth.register');
    }
}
