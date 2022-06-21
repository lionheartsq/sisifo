<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $table = 'grupos';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'detalleGrupos',
        'estado'
    ];  
}

