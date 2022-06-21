<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    //
	protected $table = 'departamentos';
	protected $primaryKey = 'ID_DEPARTAMENTOS';
	public $timestamps = false;

	protected $fillable = [
		'DETALLE_DEPARTAMENTOS',
		'ESTADO'
	];

	public function ciudades()
	{
		return $this->hasMany(Ciudades::class, 'ID_DEPARTAMENTOS');
	}
}
