<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{   
    // show forget password form
    public function forgetPassword(){
        return view('users.forget-password');
    }

    // send forget password form (email address)
    public function forgetPasswordPost(Request $request){
        $request->validate([
            'email'    => ['required','email','exists:users'],
        ]);

        // check password_reset_tokens table that if email is already sent or not
        $email_token = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if ($email_token) {
            return redirect()->back()->with('error','Forgotten password form has sent for your email');
        }
        $forgetToken = str()->random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $forgetToken,
            'created_at' => Carbon::now(),
        ]);

        // send token via email
        // Mail::send('emails.forget-password',['token'=>$forgetToken], function($message) use($request) {
        //     $message->to($request->email);
        //     $message->subject('Reset password');
        // });
    }

    // Show reset password form
    public function resetPassword(string $token){
        return view('users.reset-password', compact('token'));
    }

    // reset password
    public function resetPasswordPost(Request $request) {
        $request->validate([
            'token'=> ['required'],
            'password'=> ['required', 'min:4','confirmed']
        ]);

        // get info from password_reset_tokens table by token
        $resetPassword = DB::table('password_reset_tokens')->where([
            'token'=> $request->token,
        ])->first();

        if (!$resetPassword) {
            return redirect()->back()->with('error','Invalid credentials');
        }

        User::where('email', $resetPassword->email)->update([
            'password'=> Hash::make($request->password),
        ]);

        // $resetPassword->delete();
        $resetPassword = DB::table('password_reset_tokens')->where([
            'token'=> $request->token,
        ])->delete();


        return redirect()->route('login');
    }
}
