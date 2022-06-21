<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detallepedidos extends Model
{
    protected $table = 'detallepedidos';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'valor',
        'valorImpuesto',
        'total',
        'idPedidos',
        'idProductos'
    ]; 
}
