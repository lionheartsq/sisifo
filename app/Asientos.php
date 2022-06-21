<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asientos extends Model
{
    //
	protected $table = 'asientos';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'idTipologia' => 'int'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'fecha',
		'concepto',
		'detalle',
		'idTipologia'
	];

	public function tipologia()
	{
		return $this->belongsTo(Tipologia::class, 'id');
	}
}
