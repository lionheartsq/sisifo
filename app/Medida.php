<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    protected $table = 'media';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'nombre',
        'estado'
    ];  
}