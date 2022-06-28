<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnUpdateManagerToNullTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('completed_form_field_histories', function (Blueprint $table) {
            $table->string('updated_manager_name')->nullable()->change();
            $table->string('updated_manager_first_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('completed_form_field_histories', function (Blueprint $table) {
            $table->dropColumn('updated_manager_name')->change();
            $table->dropColumn('updated_manager_first_name')->change();
        });
    }
}
