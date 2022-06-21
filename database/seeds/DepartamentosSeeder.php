<?php

use App\Departamentos;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/departamentos.json'));
        foreach ($data as $item){
            Departamentos::create(array(
                'detalle' => $item->detalle,
                'estado' => $item->estado
            ));
            }
    }
}
