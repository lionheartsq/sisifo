<?php

use App\Medida;
use Illuminate\Database\Seeder;

class MedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/medida.json'));
        foreach ($data as $item){
            Medida::create(array(
                'nombre' => $item->nombre,
                'estado' => $item->estado,
                'idEmpresa' => $item->idEmpresa
            ));
            }
    }
}
