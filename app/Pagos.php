<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'pagos';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'fechaAbono',
        'valorPago',
        'abono',
        'idPedidos',
        'idEmpresa'
    ]; 
}