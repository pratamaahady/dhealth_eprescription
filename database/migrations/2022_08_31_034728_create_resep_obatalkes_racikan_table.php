<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepObatalkesRacikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_obatalkes_racikan', function (Blueprint $table) {
            $table->foreignId('resep_id');
            $table->foreign('resep_id')->references('id')->on('resep')->cascadeOnDelete();
            $table->foreignId('obatalkes_racikan_id');
            $table->foreign('obatalkes_racikan_id')->references('id')->on('obatalkes_racikan');
            $table->foreignId('signa_id');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m');
            $table->decimal('quantity',15,2);

            $table->primary(['resep_id','obatalkes_racikan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_obatalkes_racikan');
    }
}
