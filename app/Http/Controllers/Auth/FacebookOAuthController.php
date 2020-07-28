<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth; //ログイン認証のために追加
use App\Models\FacebookAccount;  // ログイン認証のためにFacebookAccountモデルを読み込む

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
        try{
            // Socialiteの以下のメソッドで、facebookから送られてきたユーザー情報を取り出す。
            $socialUser = Socialite::driver('facebook')->user();
    
            // すでに登録済みなら、FacebookAccountモデルを通して、facebook_accountsテーブルからユーザー認証情報を取得できる。
            $user = FacebookAccount::where('email',$socialUser->getEmail())->first();
            
            // $userがnullじゃない＝すでに登録済みなら、
            if($user){
                //ログイン処理に移る。
                if(Auth::guard('facebook')->attempt(['email' => $user->email])){
                    return response()->json(['sucsess'=>true, "message"=>'Login succeeded']);
                };

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

            // 未登録なら、新規登録する。
            $userName = $socialUser->getName();
            $userEmail = $socialUser->getEmail();
            $userFacebookId = $socialUser->getId();

            $user = FacebookAccount::create([
                'name' => $userName,
                'email' => $userEmail,
                'facebook_id' => $userFacebookId
            ]);
            
            // 新規登録が上手くいったら、続けてログイン処理に進む。
            if($user){
                if(Auth::guard('facebook')->attempt(['email' => $user->email])){
                    return response()->json(['sucsess'=>true, "message"=>'Registration and Login succeeded']);
                };
            }

        }catch(Exception $e){
            return response()->json(['sucsess'=>false, "message"=>'Registration or Login failed']);
        }
    }
}
