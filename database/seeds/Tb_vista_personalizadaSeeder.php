<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tb_vista_personalizadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tb_vista_personalizada')->insert([
            'escritorio' => 1,
            'documentacion' => 1,
            'administracion' => 1,
            'produccion' => 1,
            'personas' => 1,
            'gestionFinanciera' => 1,
            'idUser' => 1,
            'idEmpresa' => '1'
        ]);
    }
}
