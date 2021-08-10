<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listaegreso extends Model
{
	    protected $fillable=[
          'id',
          'id_egreso',
        'costo',
        'categoria',
        'razon',
        
        ];
            public $timestamps = false;

}