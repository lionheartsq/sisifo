<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'razonSocial',
        'representante',
        'nit',
        'regimen',
        'direccion',
        'telefonos',
        'tipo',
        'estado'
    ];
}
