<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function authenticate(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         return redirect()->intended(route('posts.index'))->with('success', 'Logged in successfully!');
    //     }

    //     // Authentication failed
    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //         'password' => 'Please double-check your email and password.',
    //     ]);
    // }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken; 
            return response()->json([
                'access_token' => $token, 
                'id' => $user->id,
                'user_Type' => $user->user_Type,
                'message' => 'Authenticated successfully'
            ]);
        }
    
        return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }
    
    

    
}
