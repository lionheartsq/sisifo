<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->id();
			$table->bigInteger('documento');
            $table->string('email')->unique('email');
			$table->string('nombres', 250);
			$table->string('apellidos', 250);
            $table->string('password', 255);
            $table->foreignId('idEmpresa')->constrained('tb_configuracion_basica');
            $table->foreignId('idRol')->constrained('roles');
			$table->integer('estado')->default('1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
