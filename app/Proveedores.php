<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table = 'proveedores';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'nit',
        'razonSocial',
        'contacto',
        'telefono',
        'direccion',
        'correo',
        'estado'
    ];
} 
