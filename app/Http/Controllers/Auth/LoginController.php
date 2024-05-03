<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the user with the given email
        $user = DB::table('users')->where('email', $request->email)->first();

        // Check if a user was found and if the password matches
        if ($user &&$request->password ==$user->password) {
            // Authentication successful
            Auth::loginUsingId($user->id); // Log in the user
            return redirect()->intended(route('posts.index'))->with('success', 'Logged in successfully!');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'Please double-check your email and password.',
        ]);
    }
}
