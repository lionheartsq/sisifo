<?php

use App\Proveedores;
use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/proveedores.json'));
        foreach ($data as $item){
            Proveedores::create(array(
                'nit' => $item->nit,
                'razonSocial' => $item->razonSocial,
                'contacto' => $item->contacto,
                'telefono' => $item->telefono,
                'direccion' => $item->direccion,
                'correo' => $item->correo,
                'estado' => $item->estado,
                'idEmpresa' => $item->idEmpresa
            ));
            }
    }
}
