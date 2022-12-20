<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Horas;

class HorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/horas.json'));
        foreach ($data as $item){
            Horas::create(array(
                'hora' => $item->hora
            ));
            }
        // DB::table('horas')->insert([
        //     'hora' => '00:00 - 2:00 am'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '2:00 - 4:00 am'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '4:00 - 6:00 am'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '6:00 - 8:00 am'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '8:00 - 10:00 am'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '10:00 - 12:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '12:00 - 2:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '2:00 - 4:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '4:00 - 6:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '6:00 - 8:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '8:00 - 10:00 pm'
        // ]);
        // DB::table('horas')->insert([
        //     'hora' => '10:00 - 12:00 am'
        // ]);
    }
}
