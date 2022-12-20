<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    //
    protected $table = 'reserva';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['idSala','reservaNombre','fecha','idHora','observaciones','estado'];
}
