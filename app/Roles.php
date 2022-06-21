<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'idroles';
	public $timestamps = false;

	protected $fillable = [
		'rol'
	];

	public function usuarios()
	{
		return $this->hasMany(User::class, 'idusuarios');
	}
}
