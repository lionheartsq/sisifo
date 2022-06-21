<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
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
        'idtipoFactura', 
        'idProveedores', 
        'idEmpresa', 
        'estado'
    ]; 
}
