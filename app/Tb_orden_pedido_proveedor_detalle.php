<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_orden_pedido_proveedor_detalle extends Model
{
    //
    protected $table = 'tb_orden_pedido_proveedor_detalle';

    protected $fillable = [
        'idProducto',
        'cantidad',
        'valor',
        'estado',
        'idEmpresa'
    ];

    public $timestamps = false;
}
