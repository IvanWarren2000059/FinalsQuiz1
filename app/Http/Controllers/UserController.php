<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(){

    }

    // public function store(Request $request){
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = bcrypt($request->password);        
    //     $user->save();
    //     return redirect('/login');
    // }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);
    
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_Type = $request->user_Type;
            $user->password = bcrypt($request->password);        
            $user->save();
    
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->validator->getMessageBag()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while registering user'], 500);
        }
    }
    
}
