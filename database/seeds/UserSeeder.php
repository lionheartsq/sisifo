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
    }
}
