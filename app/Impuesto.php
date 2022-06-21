<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    protected $table = 'impuesto';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'nombre',
        'valor',
        'estado'
    ]; 
}
