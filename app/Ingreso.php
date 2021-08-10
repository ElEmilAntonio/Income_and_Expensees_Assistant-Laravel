<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
	    protected $fillable=[
          'id',
          'fecha',
        'manana',
        'tarde',
        'noche',
        ];
            public $timestamps = false;

}