<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePandemicStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pandemic_stats', function (Blueprint $table) {
            $table->id();
            $table->enum('label',['CONFIRMED','SICK','HEALED','DEAD'])->nullable(false);
            $table->integer('value')->default(0);
            $table->date('last_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pandemic_stats');
    }
}
