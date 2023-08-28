<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_vista_personalizada extends Model
{
    //
    protected $table = 'tb_vista_personalizada';

    protected $fillable = [
        'escritorio',
        'documentacion',
        'administracion',
        'produccion',
        'personas',
        'gestionFinanciera',
        'idUser',
        'idEmpresa'
];

    public $timestamps = false;
}
