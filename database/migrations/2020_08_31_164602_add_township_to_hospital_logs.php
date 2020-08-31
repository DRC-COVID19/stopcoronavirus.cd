<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTownshipToHospitalLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospital_logs', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('township_id')->nullable() ;

            $table->foreign('township_id')->references('id')->on('townships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospital_logs', function (Blueprint $table) {
            //
            $table->dropForeign('hospital_logs_township_id_foreign');
            $table->dropColumn('township_id');
        });
    }
}
