<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcursionLugar extends Model
{
    protected $fillable = ["excursion_id","lugar_id"];
    protected $table = 'excursion_lugar';

    public function lugar()
    {
        return $this->hasOne('App\Lugar', 'id', 'lugar_id');
    }

}
