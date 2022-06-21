<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Migrations extends Model
{
    protected $table = 'migrations';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'migration',
        'batch'
    ];  
}