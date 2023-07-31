<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['name', 'email', 'password','estado'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    //protected $casts = ['email_verified_at' => 'datetime'];

    protected $table = 'users';

    protected $fillable = ['documento','email','nombres','apellidos','password','idEmpresa','idRol','estado'];

    public $timestamps = false;

    public function vistas() {
        return $this->hasOne('App\Tb_vista_personalizada', 'idUser', 'id');
    }
}
