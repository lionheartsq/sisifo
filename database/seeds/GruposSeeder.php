<?php

use App\Grupos;
use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/grupos.json'));
        foreach ($data as $item){
            Grupos::create(array(
                'detalleGrupos' => $item->detalleGrupos,
                'estado' => $item->estado,
                'idEmpresa' => $item->idEmpresa
            ));
            }
    }
}
