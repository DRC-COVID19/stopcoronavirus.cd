<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('step');
            $table->unsignedBigInteger('form_id');

            $table->foreign('form_id')->references('id')->on('forms');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_steps');
    }
}
