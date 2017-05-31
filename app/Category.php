<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'categories';

    public function accessCodes()
    {
        return $this->belongsToMany('App\AccessCode', 'category_access_codes');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'category_tags');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function getFilms()
    {
        if(!isset($this->id) || !isset($this->tags)) {
            throw new \Exception('Property doesn\'t exist.');
        }

        $intersection = Film::all();
        foreach ($this->tags as $tag) {
            $intersection = $intersection->intersect($tag->films);
        }

        return $intersection;
    }
}
