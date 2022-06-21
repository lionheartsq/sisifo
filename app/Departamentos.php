<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    //
	protected $table = 'departamentos';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'detalle',
		'estado'
	];

	public function ciudades()
	{
		return $this->hasMany(Ciudades::class, 'idDepartamentos');
	}
}
