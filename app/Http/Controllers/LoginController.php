<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


class LoginController extends Controller
{
    // view login page if not AUTH
    public function login()
    {
        return view('auth.login');
    }

    // handle to google sign in
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    // handle data from google authentication
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // check if user exist within DB
        $user = User::where('email', $googleUser->email)->first();

        // if Exist update verification, if not create new one
        $userAuth = [];
        if(!$user){
            $userAuth = User::create([
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'password' => 0,
                'email_verified_at' => now()
            ]);
        }else{
            $user->update([
                'email_verified_at' => now()
            ]);
            $userAuth = $user;
        }

        // Create Session Laravel
        Auth::login($userAuth);

        // redirect to input page
        return redirect()->route('index.input');
    }
}
