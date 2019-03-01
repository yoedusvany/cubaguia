<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $fillable = ['nombre', 'lugar_id'];
    protected $table = 'img';

    public function lugar()
    {
        return $this->belongsTo('App\Lugar');
    }
}
