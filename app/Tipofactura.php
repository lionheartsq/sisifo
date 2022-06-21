<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipofactura extends Model
{
    protected $table = 'tipofactura';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'detalle',
        'estado'
    ];  
}
