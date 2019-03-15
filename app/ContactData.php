<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactData extends Model
{
    protected $fillable = ['address', 'email', 'phone'];
    protected $table = "contact_data";
}
