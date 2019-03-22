<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'title_en', 'desc', 'desc_en', 'image'];
    protected $table = 'slider';
}
