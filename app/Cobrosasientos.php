<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobrosasientos extends Model
{
    protected $table = 'cobrosasientos';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'idCobros',
        'idAsientos'
    ];
}
