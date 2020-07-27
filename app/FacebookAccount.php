<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FacebookAccount extends Authenticatable
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
