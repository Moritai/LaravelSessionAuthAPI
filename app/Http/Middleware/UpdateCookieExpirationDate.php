<?php

namespace App\Http\Middleware;

use Closure;
// 新たな有効期限を算出するために追加
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
// Cookie更新のために新たなCookieを作成するために追加
use Symfony\Component\HttpFoundation\Cookie;

class UpdateCookieExpirationDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);  // (1)
        $this->updateCookieExpirationDate($request, $response);  // (2)
        return $response;  // (3)

    }

    private function updateCookieExpirationDate($request, $response){
        if($request->hasCookie('login_flag')){
            // config/session.phpの設定を使用できるように \Config::get('session')で読み込む。
            $config = \Config::get('session');
            // 新たな有効期限の算出
            $expirationDate = $config['expire_on_close'] ? 0 : Date::instance(
                Carbon::now()->addRealMinutes($config['lifetime'])
            );

            // cookieをセットしなおすことで、更新する
            $response->headers->setCookie(new Cookie(
                'login_flag',//cookie名
                true,//cookieの値
                $expirationDate,// cookieの有効期限（指定しない場合ブラウザが閉じるまでが有効期限となる）
                $config['path'], 
                $config['domain'], 
                $config['secure'] ?? false,
                false,//httponlyを有効にするか 
                false, 
                $config['same_site'] ?? null
            ));
    
        }
    }
}
