<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagosasientos extends Model
{
    protected $table = 'pagosasientos';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'idPagos',
        'idAsientos'
    ];  
}
