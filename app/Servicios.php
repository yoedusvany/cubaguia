<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    //
    protected $fillable = ['name','icon'];
    protected $table = "services";
}
