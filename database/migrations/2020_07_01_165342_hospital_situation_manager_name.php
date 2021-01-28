<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HospitalSituationManagerName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospital_situations', function (Blueprint $table) {
            $table->string('updated_manager_name')->nullable();
            $table->string('created_manager_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospital_situations', function (Blueprint $table) {
            $table->dropColumn('updated_manager_name');
        });
        Schema::table('hospital_situations', function (Blueprint $table) {

          $table->dropColumn('created_manager_name');
      });
    }
}
