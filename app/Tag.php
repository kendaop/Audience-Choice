<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function films()
    {
        return $this->belongsToMany('App\Film', 'film_tags');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_tags');
    }
}
