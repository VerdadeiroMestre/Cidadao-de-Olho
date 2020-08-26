<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    protected $fillable = [
        'nome', 'redes_Sociais', 'verba_Indenizatoria',
    ];
}
