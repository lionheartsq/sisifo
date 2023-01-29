<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    //
    protected $table = 'salas';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['nombre','ubicacion','descripcion','estado'];
}
