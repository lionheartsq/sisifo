<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'ocupacion';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'detalle',
        'estado',
        'fechaIngreso',
        'fechaSalida',
        'horaIngreso',
        'horaSalida',
        'idCliente',
        'idHabitacion',
        'idEmpresa'
    ];
}
