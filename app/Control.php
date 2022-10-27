<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    //
    protected $table = 'control';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['documento','nombres','apellidos','ingreso','salida','estado'];
    
}
