<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipologia extends Model
{
    //
	protected $table = 'tipologia';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function asientos()
	{
		return $this->hasMany(Asientos::class, 'id');
	}
}
