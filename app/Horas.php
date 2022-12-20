<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horas extends Model
{
    //
    protected $table = 'horas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = ['hora'];
    
}
