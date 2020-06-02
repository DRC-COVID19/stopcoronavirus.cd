<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePandemicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pandemics', function (Blueprint $table) {
            $ $table->id();
            $table->integer('confirmed')->default(0);
            $table->integer('sick')->nullable();
            $table->integer('seriously')->nullable();
            $table->integer('healed')->nullable();
            $table->integer('dead')->nullable();
            $table->integer('imported')->nullable();
            $table->integer('local')->nullable();
            $table->datetime('last_update');
            $table->integer('province_id')->index()->unsigned();
            $table->integer('township_id')->index()->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pandemics');
    }
}
