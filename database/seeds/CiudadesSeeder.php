<?php

use App\Ciudades;
use Illuminate\Database\Seeder;

class CiudadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/ciudades.json'));
        foreach ($data as $item){
            Ciudades::create(array(
                'detalle' => $item->detalle,
                'estado' => $item->estado,
                'idDepartamentos' => $item->idDepartamentos
            ));
            }
    }
}
