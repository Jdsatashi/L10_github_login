<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function githubRedirect(){

        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(){
        try{
            $user = Socialite::driver('github')->user();

            $gitUser = User::find($user->id);
            if(!$gitUser){
                $gitUser = User::updateOrCreate([
                    'github_id' => $user->id,
                ],[
                    'name' => $user->nickname,
                    'nickname' => $user->nickname,
                    'email' => $user->email,
                    'github_token' => $user->token,
                    'auth_type' => 'github',
                    'password' => Hash::make(Str::random(10))
                ]);
            }
            Auth::login($gitUser);
            return redirect(RouteServiceProvider::HOME);
        } catch(Exception $e) {
            echo "Errors: {$e}";
        }
    }
}
