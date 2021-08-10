<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
	    protected $fillable=[
          'id',
          'inicio',
        'final',
        'ingreso',
        'egreso',
        'total',
        
        ];
            public $timestamps = false;

}