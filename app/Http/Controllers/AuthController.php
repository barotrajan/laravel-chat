<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate the Incoming Request
     *
     * @param \Illuminate\Http\Request $request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->withSuccess('Signed in');
        }

        return back()->withErrors('Credentials are not Valid!');
    }

    /**
     * Logout from the site
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
