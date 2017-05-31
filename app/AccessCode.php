<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $table = 'access_codes';

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_access_codes');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}
