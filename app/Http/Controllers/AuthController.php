<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request){
        $input_fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($input_fields, $request->remember)) {            
            return redirect()->intended();
        } else {
            return back()->withErrors([
                'failed' => 'email or password is incorrect'
            ]);
        };
    }
    
    public function logout(Request $request)
    {
        // logout the user
        Auth::logout();
        // invalidate user's session
        $request->session()->invalidate();
        // Regenerate CSRF token 
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
