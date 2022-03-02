<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompletedForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('completed_forms', function (Blueprint $table) {
            $table->date('last_update')->after('hospital_id');
            $table->string('created_manager_name')->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('completed_forms', function (Blueprint $table) {
            $table->dropColumn('last_update');
            $table->dropColumn('create_manager_name');
        });
    }
}
