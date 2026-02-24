<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //login form
    public function create()
    {
        return view('auth.seller.login');
    }

    //login store
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' =>$request->email,
            'password' =>$request->password,
            'role' => 'seller',
        ],$request->remember))
        {
            $request->session()->regenerate();

            return redirect()->route('seller.dashboard');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials or not a seller account.',
        ])->onlyInput('email');
    }


    // logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('seller.login');

    }
}
