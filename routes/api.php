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


Route::get('/guest', function () {
    return response()->json([
        'message' => 'Hello, guest'
    ]);
});

// prefixはルートのパスに付与するもの（下の例だとauth/twitterがパスとなる）
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/facebook', 'Auth\FacebookOAuthController@getRedirectUrl');
    // .envに登録したFACEBOOK_CALLBACK_URL
    Route::get('facebook/callback', 'Auth\FacebookOAuthController@handleProviderCallback');
});


// まとめて複数のルートにauthのミドルウェアを適用する場合

Route::group(['middleware' => ['auth:facebook']], function() {

    Route::get('/test', function () {
        return response()->json([
            'test' => "clear"
        ]);
    });

});

// Route::middleware(['auth:facebook','auth:web'])->group(function () {
    
//     Route::get('/test', function () {
//         return response()->json([
//             'test' => "clear"
//         ]);
//     });
//     // Route::post('logout', 'AuthController@logout')->name('logout');
// });

