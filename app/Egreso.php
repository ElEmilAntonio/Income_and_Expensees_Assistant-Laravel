<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
	    protected $fillable=[
          'id',
          'fecha',
        'egreso',
        
        ];
            public $timestamps = false;

}