<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresa')->insert([
            'razonSocial' => 'Softclass',
            'representante' => 'Luis García',
            'nit' => '13514998',
            'regimen' => 'Simplificado',
            'direccion' => 'Carrera 13 # 50-11',
            'telefonos' => '3158572686',
            'tipo' => '1',
        ]);
    }
}
