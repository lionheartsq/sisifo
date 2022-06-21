<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libromayor extends Model
{
    protected $table = 'libromayor';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'valorEntrada',
        'valorSalida',
        'acumulado',
        'idAsientos'
    ];   
}
