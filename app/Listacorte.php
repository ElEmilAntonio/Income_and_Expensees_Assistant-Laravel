<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listacorte extends Model
{
	    protected $fillable=[
          'id',
          'id_corte',
        'fecha', 
       ];
            public $timestamps = false;

}