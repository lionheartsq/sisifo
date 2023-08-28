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
            'direccion' => 'Carrera 13 # 50-11',
            'nit' => '13514998',
            'telefonos' => '3158572686',
            'representante' => 'Luis García',
            'regimen' => 'Simplificado',
            'cajaCompensacion' => '1',
            'arl' => '1',
            'nivelRiesgo' => '1',
            'tipo' => '1',
            'idTipoNomina' => '1',
            'estado' => '1'
        ]);

        DB::table('empresa')->insert([
            'razonSocial' => 'Zaida',
            'direccion' => 'Carrera 13 # 50-11',
            'nit' => '13514998',
            'telefonos' => '3158572686',
            'representante' => 'Zaida García',
            'regimen' => 'Simplificado',
            'cajaCompensacion' => '1',
            'arl' => '1',
            'nivelRiesgo' => '1',
            'tipo' => '1',
            'idTipoNomina' => '1',
            'estado' => '1'
        ]);

        DB::table('empresa')->insert([
            'razonSocial' => 'Daniela',
            'direccion' => 'Carrera 13 # 50-11',
            'nit' => '13514998',
            'telefonos' => '3158572686',
            'representante' => 'Daniela Uribe',
            'regimen' => 'Simplificado',
            'cajaCompensacion' => '1',
            'arl' => '1',
            'nivelRiesgo' => '1',
            'tipo' => '1',
            'idTipoNomina' => '1',
            'estado' => '1'
        ]);
    }
}
