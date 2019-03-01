<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    //
    protected $fillable = ['nombre','desc'];
    protected $table = 'lugar';

    public function imgs()
    {
        return $this->hasMany('App\Imagen');
    }
}
