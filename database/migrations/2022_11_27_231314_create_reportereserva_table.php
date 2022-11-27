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
			$table->foreignId('idSala')->constrained('reserva');
            $table->string('descripcionSala', 250);
            $table->string('reservaNombre', 250);
            $table->timestamp('fecha')->useCurrent();
            $table->string('observaciones', 250);
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
