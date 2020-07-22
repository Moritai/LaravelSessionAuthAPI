<?php
 
return [
 
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
 
    'paths' => ['api/*'], //CORSを適用するパス（デフォルトではapi.phpに記されたルートすべて）
 
    'allowed_methods' => ['*'],//CROSを適用するメソッド(デフォルトではすべて)
 
    'allowed_origins' => ['http://localhost:8081'],//CROSを適用するオリジン(デフォルトではすべて＝どのオリジンからでも許可)　※
 
    'allowed_origins_patterns' => [],
 
    'allowed_headers' => ['*'],
 
    'exposed_headers' => [],
 
    'max_age' => 0,
 
//'Access-Control-Allow-Credentials' header in the response 
    'supports_credentials' => true, //cookieを使用の場合はtrue（cookieの使用を許可するかどうか）
];