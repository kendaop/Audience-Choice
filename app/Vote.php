<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function film()
    {
        return $this->belongsTo('App\Film');
    }

    public function accessCode()
    {
        return $this->belongsTo('App\AccessCode');
    }
}
