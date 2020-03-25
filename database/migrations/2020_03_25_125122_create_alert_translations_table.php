<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('locale');
            $table->integer('alert_id')->unsigned()->index();
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('alert_id')
            ->references('id')
            ->on('alerts')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
        });
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert_translations');
        Schema::table('alerts', function (Blueprint $table) {
            $table->string('title');
            $table->text('content')->nullable();
        });
    }
}
