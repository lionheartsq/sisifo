<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitacion';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'detalle',
        'estado',
        'fecha',
        'idTipo',
        'idEmpresa'
    ];
}
