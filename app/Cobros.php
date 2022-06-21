<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobros extends Model
{
    protected $table = 'cobros';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'fechaAbono',
        'valorCobro',
        'abono',
        'idFacturas',
        'idEmpresa'
    ];
}
