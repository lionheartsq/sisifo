<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    protected $table = 'facturas';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'consecutivo',
        'fecha',
        'valor',
        'impuesto',
        'total',
        'vendedor',
        'idVendedor', 
        'tipoFactura', 
        'idClientes', 
        'idEmpresa', 
        'estado'
    ]; 
} 