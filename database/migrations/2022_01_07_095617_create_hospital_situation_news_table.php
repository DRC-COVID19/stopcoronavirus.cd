<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalSituationsNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_situations_new', function (Blueprint $table) {
            $table->id();
            $table->foreign('hospital_id')->references('id')->on('hospitals');
            $table->string('value');
            $table->foreign('form_fields_id')->references('id')->on('form_fields');
            $table->timestamps();
            $table->datetime('last_update');
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
        Schema::dropIfExists('hospital_situations_new');
    }
}
