<?php

use Illuminate\Database\Seeder;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'documento'=>'1234567',
            'email' => 'ljgarcia899@misena.edu.co',
            'nombres'=>'Luis',
            'apellidos'=>'Garcia',
            'idEmpresa'=>'1',
            'idRol'=>'1',
            'password' => bcrypt('12345'),
            'estado'=>'1'
        ]);
        DB::table('users')->insert([
            'documento'=>'1005288955',
            'email' => 'zaida@correo.co',
            'nombres'=>'Zaida',
            'apellidos'=>'Garcia',
            'idEmpresa'=>'2',
            'idRol'=>'1',
            'password' => bcrypt('12345'),
            'estado'=>'1'
        ]);
        DB::table('users')->insert([
            'documento'=>'1098735648',
            'email' => 'daniela@correo.co',
            'nombres'=>'Daniela',
            'apellidos'=>'Uribe',
            'idEmpresa'=>'3',
            'idRol'=>'1',
            'password' => bcrypt('12345'),
            'estado'=>'1'
        ]);
    }
}
