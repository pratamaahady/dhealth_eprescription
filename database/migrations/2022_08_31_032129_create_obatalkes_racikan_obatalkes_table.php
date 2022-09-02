<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatalkesRacikanObatalkesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obatalkes_racikan_obatalkes', function (Blueprint $table) {
            $table->foreignId('obatalkes_racikan_id');
            $table->foreign('obatalkes_racikan_id')->references('id')->on('obatalkes_racikan')->cascadeOnDelete();
            $table->foreignId('obatalkes_id');
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m')->cascadeOnDelete();
            $table->decimal('quantity',15,2);

            $table->primary(['obatalkes_racikan_id','obatalkes_id'],'obatalkes_racikan_obatalkes_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obatalkes_racikan_obatalkes');
    }
}
