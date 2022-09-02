<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepObatalkesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_obatalkes', function (Blueprint $table) {
            $table->foreignId('resep_id');
            $table->foreign('resep_id')->references('id')->on('resep')->cascadeOnDelete();
            $table->foreignId('obatalkes_id');
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m');
            $table->foreignId('signa_id');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m');
            $table->decimal('quantity',15,2);

            $table->primary(['resep_id','obatalkes_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_obatalkes');
    }
}
