<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HospitalsNewAttribut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn('occupied_Beds')->default(0);
            $table->dropColumn('occupied_respirators')->default(0);

            $table->integer('foam_beds')->default(0);
            $table->integer('resuscitation_beds')->default(0);

            //Personal
            $table->integer('doctors')->default(0);
            $table->integer('nurses')->default(0);
            $table->integer('para_medicals')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn('foam_beds');
            $table->dropColumn('resuscitation_beds');
            
            //Personal
            $table->dropColumn('doctors');
            $table->dropColumn('nurses');
            $table->dropColumn('para_medicals');
        });
    }
}
