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
    }
}
