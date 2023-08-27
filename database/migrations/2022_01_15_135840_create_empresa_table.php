<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa', function(Blueprint $table)
		{
			$table->id();
			$table->string('razonSocial', 500);
			$table->string('direccion', 500);
			$table->string('nit', 50);
			$table->string('telefonos', 250);
			$table->string('representante', 500);
			$table->string('regimen', 50);
            $table->string('cajaCompensacion',255);
            $table->string('arl',255);
            $table->integer('nivelRiesgo');
			$table->enum('tipo', array('1','2','3'))->default('2')->comment('1-Ppal 2-Suc 3-Maq');
            $table->foreignId('idTipoNomina')->constrained('tb_tipo_nomina');
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
		Schema::drop('empresa');
	}

}
