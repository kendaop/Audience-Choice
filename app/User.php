<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function accessCodes()
    {
        return $this->hasMany('App\AccessCode');
    }
}
