<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    protected $table = 'reservas';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'detalle',
        'estado',
        'fecha',
        'idCliente',
        'idHabitacion',
        'idEmpresas'
    ];
}
