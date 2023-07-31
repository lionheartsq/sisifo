<?php

use App\Roles;
use Illuminate\Database\Seeder;

class Tb_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_roles.json'));
        foreach ($data as $item){
            Roles::create(array(
                'id' => $item->IdRol,
                'rol' => $item->Rol,
            ));
            }
        /*
        DB::table('tb_rol')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('tb_rol')->insert([
            'rol' => 'Empresario',
        ]
        );
        */

    }
}
