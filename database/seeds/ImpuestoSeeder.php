<?php

use App\Impuesto;
use Illuminate\Database\Seeder;

class ImpuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/impuesto.json'));
        foreach ($data as $item){
            Impuesto::create(array(
                'nombre' => $item->nombre,
                'valor' => $item->valor,
                'estado' => $item->estado
            ));
            }
    }
}
