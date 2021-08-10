<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
	    protected $fillable=[
          'id',
          'id_user',
        'fecha',
        'hora',
        ];
            public $timestamps = false;

}