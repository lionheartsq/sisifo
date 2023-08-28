<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    //
    protected $table = 'empleados';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'documento',
        'nombres',
        'apellidos',
        'cargo',
        'direccion',
        'telefono',
        'email',
        'estado',
        'idEmpresa'
    ];
}
