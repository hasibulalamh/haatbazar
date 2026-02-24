<?php

namespace App\Http\Controllers\Buyer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //create login form
    public function create()
    {
        return view('auth.buyer.login');
    }

    // login store
    public function store(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' =>$request->email,
            'password' =>$request->password,
            'role' => 'buyer',
        ],$request->remember))
        {
            $request->session()->regenerate();

            return redirect()->route('/');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials or not a buyer account.',
        ])->onlyInput('email');
    }

    // logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('buyer.login');

    }
 }
