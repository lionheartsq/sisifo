<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    //
	protected $table = 'ciudades';
	protected $primaryKey = 'ID_CIUDADES';
	public $timestamps = false;

	protected $casts = [
		'ID_DEPARTAMENTOS' => 'int'
	];

	protected $fillable = [
		'DETALLE_CIUDADES',
		'ESTADO',
		'ID_DEPARTAMENTOS'
	];

	public function departamentos()
	{
		return $this->belongsTo(Departamentos::class, 'ID_DEPARTAMENTOS');
	}
}
