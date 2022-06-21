<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detallefacturas extends Model
{
    protected $table = 'detallefacturas';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'valor',
        'valorImpuesto',
        'total',
        'idFacturas',
        'idProductos'
    ];
}
