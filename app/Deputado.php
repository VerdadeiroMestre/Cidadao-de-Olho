<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    protected $casts = [
        'redesSociais' => 'array'
    ];
}
