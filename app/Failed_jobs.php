<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Failed_jobs extends Model
{
    protected $table = 'failed_jobs';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = [
        'uuid',
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
    ];  
}
