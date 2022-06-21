<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
	protected $primaryKey = 'id';
	public $timestamps = false;

    protected $fillable = ['documento','email','nombres','apellidos','password','estado'];

    public function roles() {
        return $this->hasMany(Roles::class, 'id');
    }
}
