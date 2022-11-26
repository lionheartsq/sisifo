<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipofacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipofactura')->insert([
            'detalle' => 'Contado',
            'estado' => '1',
        ]);
        DB::table('tipofactura')->insert([
            'detalle' => 'Crédito',
            'estado' => '1',
        ]);
    }
}
