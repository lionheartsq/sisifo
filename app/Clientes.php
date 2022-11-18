<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'cedula',
        'nombres',
        'apellidos',
        'direccion',
        'telefono',
        'correo',
        'idEmpresa',
        'estado'
    ];
}
