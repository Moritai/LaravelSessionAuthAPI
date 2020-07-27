<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth; //ログイン認証のために追加
use App\FacebookAccount;  // ログイン認証のためにFacebookAccountモデルを読み込む

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
            // $user = Socialite::driver('facebook')->user();
            $socialUser = Socialite::driver('facebook')->user();
            // dd($socialUser);

            // すでに登録済みなら
            // $user = FacebookAccount::firstOrNew([
            //     'email' => $socialUser->getEmail()
            // ]);

            // すでに登録済みなら、FacebookAccountモデルを通して、facebook_accountsテーブルからユーザー認証情報を取得できる。
            $user = FacebookAccount::where('email',$socialUser->getEmail())->first();
            // dd($user);
            
            // $userがnullじゃない＝すでに登録済みなら、
            if($user){
                // dd($user->email);
                $guard = Auth::guard('facebook');
                // Auth::login($user);
                // dd(['eamil' => $socialUser->getEmail(), 'id' => $socialUser->getId()]);
                // Auth::guard('facebook')->attempt(['username' => $socialUser->getEmail(), 'password' =>$socialUser->getId()]);
                dd(Auth::guard('facebook')->attempt(['email' => $socialUser->getEmail(), "facebook_id" => $socialUser->getId()]));
                if(Auth::guard('facebook')->attempt(['eamil' => $socialUser->getEmail(), 'id' => $socialUser->getId()])){
                    dd("success");
                };

                // dd($guard);
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

            }else{
                $userName = $socialUser->getName();
                $userEmail = $socialUser->getEmail();
                $userFacebookId = $socialUser->getId();
    
                $user = FacebookAccount::create([
                    'name' => $userName,
                    'email' => $userEmail,
                    'facebook_id' => $userFacebookId
                ]);
            }
    
    
            // $user->save();
            // dd($user->email);
    
            // Auth::guard('facebook')->attempt($user);
            // ['name' => $socialU, 'password' =>$socialUser->getId()]

        }catch(Exception $e){
            dd("err");
        }

        // $user->token;
    }
}
