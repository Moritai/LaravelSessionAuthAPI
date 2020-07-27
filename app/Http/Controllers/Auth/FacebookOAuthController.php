<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;


class FacebookOAuthController extends Controller
{
    /*クライアントがfacebookへ
    自分のリソースの一部をこのアプリケーションに知らせてもよいという認可を伝えるためのページへの
    リダイレクトするためのurlを取得し、それをJson形式で返す*/
    public function getRedirectUrl()
    {
        // $redirectUrl = Socialite::driver('facebook')->redirect()->getTargetUrl();

        // return response()->json([
        //     'redirect_url' => $redirectUrl
        // ]);
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        // dd("succsses");
        try{
            $user = Socialite::driver('facebook')->user();

            if($user){
                dd($user);
                // OAuth Two Providers
                // $token = $user->token;
                // $refreshToken = $user->refreshToken; // not always provided
                // $expiresIn = $user->expiresIn;

                // // All Providers
                // $user->getId();
                // $user->getNickname();
                // $user->getName();
                // $user->getEmail();
                // $user->getAvatar();

            }
        }catch(Exception $e){
            dd("err");
        }

        // $user->token;
    }
}
