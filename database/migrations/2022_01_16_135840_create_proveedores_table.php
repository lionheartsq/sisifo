<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proveedores', function(Blueprint $table)
		{
			$table->id();
			$table->string('nit', 45)->unique('nit');
			$table->string('razonSocial', 500);
			$table->string('contacto', 500)->nullable();
			$table->bigInteger('telefono')->nullable();
			$table->string('direccion', 250)->nullable();
			$table->string('correo', 250)->nullable();
			$table->integer('estado')->default(1);
            $table->foreignId('idEmpresas')->constrained('empresa');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('proveedores');
	}

}
