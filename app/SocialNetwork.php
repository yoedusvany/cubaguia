<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $fillable = ['url', 'tipo'];
    protected $table = 'social_networks';
}
