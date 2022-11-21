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
            'documento' => '13514998',
            'email' => 'ljgarcia899@misena.edu.co',
            'nombres' => 'Luis José',
            'apellidos' => 'García Pinzón',
            'password' => bcrypt('12345'),
            'idEmpresa' => '1',
            'idRol' => '1',
        ]);

        DB::table('users')->insert([
            'documento' => '12345',
            'email' => 'empresario@empresario.co',
            'nombres' => 'Empresario',
            'apellidos' => 'Prueba',
            'password' => bcrypt('12345'),
            'idEmpresa' => '1',
            'idRol' => '1',
        ]);

        DB::table('users')->insert([
            'documento' => '67890',
            'email' => 'usuario@usuario.co',
            'nombres' => 'Usuario',
            'apellidos' => 'Prueba',
            'password' => bcrypt('12345'),
            'idEmpresa' => '1',
            'idRol' => '2',
        ]);

        DB::table('users')->insert([
            'documento' => '901538355',
            'email' => 'hotelrioazul@gmail.com',
            'nombres' => 'Administrador',
            'apellidos' => 'Hotel',
            'password' => bcrypt('12345'),
            'idEmpresa' => '1',
            'idRol' => '1',
        ]);

    }
}
