<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //-------------------------------------------------------------------//
        $this->call(EmpresaSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartamentosSeeder::class);
        $this->call(CiudadesSeeder::class);
        $this->call(ClientesSeeder::class);
        $this->call(ProveedoresSeeder::class);
        $this->call(GruposSeeder::class);
        //-------------------------------------------------------------------//
    }
}
