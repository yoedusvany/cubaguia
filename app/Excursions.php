<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Excursions extends Model
{
    //
    protected $fillable = ['nombre','precio'];
    protected $table = 'excursion';

    public function lugares()
    {
        return $this->hasMany('App\ExcursionLugar', 'excursion_id', 'id');
    }
}
