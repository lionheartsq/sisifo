<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    protected $table = 'asociacion';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'idClientes',
        'idEmpresa'
    ];
}
