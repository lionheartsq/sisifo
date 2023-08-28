<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
		'rol',
        'estado'
	];

	public function usuarios()
	{
		return $this->hasMany(User::class, 'id');
	}
}
