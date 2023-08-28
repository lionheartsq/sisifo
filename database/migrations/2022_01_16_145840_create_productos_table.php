<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos', function(Blueprint $table)
		{
			$table->id();
			$table->string('plu', 250);
			$table->string('detalle', 700);
			$table->foreignId('idMedida')->constrained('tb_unidad_base');
			$table->integer('valorCompra');
			$table->integer('pvp');
			$table->foreignId('idImpuesto')->constrained('impuesto');
			$table->foreignId('idGrupos')->constrained('grupos');
			$table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
            $table->integer('estado')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('productos');
	}

}
