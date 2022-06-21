<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{
    protected $table = 'registros';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'fecha',
        'concepto',
        'detalle',
        'idAsientos',
        'entrada',
        'salida'
    ]; 
}
