<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'film_tags');
    }

    public function categories()
    {
        return $this->hasManyThrough('App\Category', 'App\Tag');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}
