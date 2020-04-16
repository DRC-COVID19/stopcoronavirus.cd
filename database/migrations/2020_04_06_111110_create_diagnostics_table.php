<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->integer('q-1');
            $table->integer('q-2');
            $table->integer('q-3');
            $table->integer('q-4');
            $table->integer('q-5');
            $table->integer('q-6');
            $table->integer('q-7')->default(0);
            $table->integer('q-8');
            $table->integer('q-9');
            $table->integer('q-10')->nullable();
            $table->integer('q-11')->nullable();
            $table->integer('q-12')->nullable();
            $table->integer('q-13')->nullable();
            $table->integer('q-14')->nullable();
            $table->integer('q-15')->nullable();
            $table->integer('q-16')->nullable();
            $table->integer('q-17')->nullable();
            $table->integer('q-18')->nullable();
            $table->integer('q-19')->nullable();
            $table->integer('q-20')->nullable();
            $table->integer('q-21')->nullable();
            $table->string('township')->nullable();
            $table->string('town')->nullable();
            $table->string('province')->nullable();
            $table->string('results_code');
            $table->text('results_message');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
           
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
        Schema::dropIfExists('diagnostics');
    }
}
