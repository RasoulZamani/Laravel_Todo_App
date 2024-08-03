<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // Show login form
    public function login(){
        if (auth()->check()){
            return redirect()->route('home');
        }
        return view('users.login');
    }

    // Log in user
    public function loginPost(Request $request){
        if (auth()->check()){
            return redirect()->route('home');
        }
        $request->validate([
            'email'    => ['required','email','exists:users'],
            'password' => ['required']
        ]);
        
        $user = User::where('email',$request->email)->first();
        if(!$user) {
            return redirect()->back()->with('error','incorrect credentials');
        }
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error','incorrect credentials');
        }

        auth()->login($user);
        $request->session()->regenerate();
        return redirect()->route('home')->with('success','You logged in successfully');

    }

    // logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success','You log out, see you soon!');
    }
        

}
