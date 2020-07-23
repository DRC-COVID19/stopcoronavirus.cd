<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('address');
            $table->integer('beds')->default(0);
            $table->integer('respirators')->default(0);
            $table->integer('masks')->default(0);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('foam_beds')->default(0);
            $table->integer('resuscitation_beds')->default(0);

            //Personal
            $table->integer('doctors')->default(0);
            $table->integer('nurses')->default(0);
            $table->integer('para_medicals')->default(0);

            $table->integer('agent_id')->index()->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_logs');
    }
}
