<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedidaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medida', function(Blueprint $table)
		{
			$table->id();
			$table->string('nombre', 45);
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
		Schema::drop('medida');
	}

}
