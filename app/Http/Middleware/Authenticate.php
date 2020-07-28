<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    // 認証が失敗した（ログイン済み出ない）場合
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // return route('login');
            // loginパスへリダイレクトする代わりに、エラーを返す（loginパスへリダイレクトはフロントのSPAで行う）
            abort(401, 'Unauthorized action.');
        }
    }
}
