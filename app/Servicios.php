<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    //
    protected $fillable = ['name','icon','desc', 'desc_en'];
    protected $table = "services";
}
