<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grupos', function(Blueprint $table)
		{
			$table->id();
			$table->string('detalleGrupos', 250);
			$table->integer('estado')->default(1);
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('grupos');
	}

}
