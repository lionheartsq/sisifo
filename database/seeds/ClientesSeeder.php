<?php

use App\Clientes;
use Illuminate\Database\Seeder;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/clientes.json'));
        foreach ($data as $item){
            Clientes::create(array(
                'cedula' => $item->cedula,
                'nombres' => $item->nombres,
                'apellidos' => $item->apellidos,
                'direccion' => $item->direccion,
                'telefono' => $item->telefono,
                'correo' => $item->correo,
                'estado' => $item->estado,
                'idEmpresa' => $item->idEmpresa
            ));
            }
    }
}
