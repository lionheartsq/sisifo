<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    //
    protected $table = 'historico';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['idEmpleado','ingreso','salida','estado'];
}
