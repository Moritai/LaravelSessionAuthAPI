<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('/guest', function () {
//     return response()->json([
//         'message' => 'Hello, guest'
//     ]);
// });

// prefixはルートのパスに付与するもの（下の例だとauth/twitterがパスとなる）
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/facebook', 'Auth\FacebookOAuthController@getRedirectUrl');
});


// まとめて複数のルートにauthのミドルウェアを適用する場合
Route::middleware('auth')->group(function () {
    
    Route::get('/test', function () {
        return response()->json([
            'user' => Auth::user()
        ]);
    });
    // Route::post('logout', 'AuthController@logout')->name('logout');
});
