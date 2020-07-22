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
    public function getRedirectUrl(): JsonResponse
    {
        $redirectUrl = Socialite::driver('facebook')->redirect()->getTargetUrl();

        return response()->json([
            'redirect_url' => $redirectUrl
        ]);
    }
}
