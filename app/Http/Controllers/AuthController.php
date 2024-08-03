<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show register form
    public function register(){
        return view('users.register');
    }

    // Register user
    public function registerPost(Request $request){
        $request->validate([
            'name'     => ['required','min:3'],
            'email'    => ['required','email','unique:users'],
            'password' => ['required','min:4', 'confirmed']
        ]);

        $user = User::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        if(!$user){
            return redirect()->back()->with('error',"Registration failed!, try again!");
        }
        
        return redirect()->route('home')->with('success','You registered successfully, Login to access the app.');
    }
}
