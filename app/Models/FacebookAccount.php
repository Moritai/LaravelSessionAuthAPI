<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //認証のためのモデルとして使用するために読み込む

class FacebookAccount extends Authenticatable
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
