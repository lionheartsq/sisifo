<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    //
	protected $table = 'ciudades';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'idDepartamentos' => 'int'
	];

	protected $fillable = [
		'detalle',
		'estado',
		'idDepartamentos'
	];

	public function departamentos()
	{
		return $this->belongsTo(Departamentos::class, 'id');
	}
}
