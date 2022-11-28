<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportereservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportereserva', function (Blueprint $table) {
            $table->id();
			$table->foreignId('idSala')->constrained('salas');
            $table->foreignId('idDescripcionSala')->constrained('salas');
            $table->foreignId('idReservaNombre')->constrained('reserva');
            $table->foreignId('idFecha')->constrained('reserva');
            $table->string('idObservaciones')->constrained('reserva');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportereserva');
    }
}
