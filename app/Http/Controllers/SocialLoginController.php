<?php

namespace App\Http\Controllers;

use App\User;
use Socialite;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
	public function redirect()
	{
	    return Socialite::driver('google')->redirect();
	}

    public function callback()
    {
    	try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();

        if($existingUser){
            auth()->login($existingUser, true);
        } else {
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->save();

            auth()->login($newUser, true);
        }

        return redirect()->to('/admin/home');
    }
}
