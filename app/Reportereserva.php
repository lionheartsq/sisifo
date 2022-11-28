<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reportereserva extends Model
{
    //
    protected $table = 'reporteReserva';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['idSala','idDescripcionSala','idReservaNombre','idFecha','idObservaciones','estado'];
}
