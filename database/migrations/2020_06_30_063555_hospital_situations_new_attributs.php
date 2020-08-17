<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HospitalSituationsNewAttributs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospital_situations', function (Blueprint $table) {

            // Par genre
            $table->integer('confirmed_female')->default(0);
            $table->integer('sick_female')->nullable();
            $table->integer('healed_female')->nullable();
            $table->integer('dead_female')->nullable();

            $table->integer('confirmed_male')->default(0);
            $table->integer('sick_male')->nullable();
            $table->integer('healed_male')->nullable();
            $table->integer('dead_male')->nullable();

            //Tranche d'age 0-19
            $table->integer('confirmed_0_19')->default(0);
            $table->integer('sick_0_19')->nullable();
            $table->integer('healed_0_19')->nullable();
            $table->integer('dead_0_19')->nullable();

            //Tranche d'age 20-40
            $table->integer('confirmed_20_40')->default(0);
            $table->integer('sick_20_40')->nullable();
            $table->integer('healed_20_40')->nullable();
            $table->integer('dead_20_40')->nullable();

            //Tranche d'age 45-50
            $table->integer('confirmed_45_50')->default(0);
            $table->integer('sick_45_50')->nullable();
            $table->integer('healed_45_50')->nullable();
            $table->integer('dead_45_50')->nullable();

            //Tranche d'age 55-64
            $table->integer('confirmed_55_64')->default(0);
            $table->integer('sick_55_64')->nullable();
            $table->integer('healed_55_64')->nullable();
            $table->integer('dead_55_64')->nullable();

            //Tranche d'age 65-74
            $table->integer('confirmed_65_74')->default(0);
            $table->integer('sick_65_74')->nullable();
            $table->integer('healed_65_74')->nullable();
            $table->integer('dead_65_74')->nullable();

            //Tranche d'age 75-84
            $table->integer('confirmed_75_84')->default(0);
            $table->integer('sick_75_84')->nullable();
            $table->integer('healed_75_84')->nullable();
            $table->integer('dead_75_84')->nullable();

            //Tranche d'age >=85
            $table->integer('confirmed_85')->default(0);
            $table->integer('sick_85')->nullable();
            $table->integer('healed_85')->nullable();
            $table->integer('dead_85')->nullable();


            $table->integer('occupied_Beds')->default(0)->nullable();
            $table->integer('occupied_respirators')->default(0)->nullable();
            $table->integer('masks')->default(0)->nullable();
            $table->integer('occupied_foam_beds')->default(0)->nullable();
            $table->integer('occupied_resuscitation_beds')->default(0)->nullable();
            $table->integer('individual_protection_equipment')->default(0)->nullable();
            $table->integer('gel_hydro_alcoolique')->default(0)->nullable();
            $table->integer('resuscitation_ventilator')->default(0)->nullable();
            $table->integer('oxygenator')->default(0)->nullable();
            $table->integer('rapid_screening')->default(0)->nullable();
            $table->integer('automate_genexpert')->default(0)->nullable();
            $table->integer('x_ray')->default(0)->nullable();
            $table->integer('check_point')->default(0)->nullable();
            $table->integer('chloroquine')->default(0)->nullable();
            $table->integer('hydrochloroquine')->default(0)->nullable();
            $table->integer('azytromicine')->default(0)->nullable();
            $table->integer('Vitamince_c')->default(0)->nullable();
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

            // Par genre
            $table->dropColumn('confirmed_female');
            $table->dropColumn('sick_female');
            $table->dropColumn('healed_female');
            $table->dropColumn('dead_female');

            $table->dropColumn('confirmed_male');
            $table->dropColumn('sick_male');
            $table->dropColumn('healed_male');
            $table->dropColumn('dead_male');

            //Tranche d'age 0-19
            $table->dropColumn('confirmed_0_19');
            $table->dropColumn('sick_0_19');
            $table->dropColumn('healed_0_19');
            $table->dropColumn('dead_0_19');

            //Tranche d'age 20-40
            $table->dropColumn('confirmed_20_40');
            $table->dropColumn('sick_20_40');
            $table->dropColumn('healed_20_40');
            $table->dropColumn('dead_20_40');

            //Tranche d'age 45-50
            $table->dropColumn('confirmed_45_50');
            $table->dropColumn('sick_45_50');
            $table->dropColumn('healed_45_50');
            $table->dropColumn('dead_45_50');

            //Tranche d'age 55-64
            $table->dropColumn('confirmed_55_64');
            $table->dropColumn('sick_55_64');
            $table->dropColumn('healed_55_64');
            $table->dropColumn('dead_55_64');

            //Tranche d'age 65-74
            $table->dropColumn('confirmed_65_74');
            $table->dropColumn('sick_65_74');
            $table->dropColumn('healed_65_74');
            $table->dropColumn('dead_65_74');

            //Tranche d'age 75-84
            $table->dropColumn('confirmed_75_84');
            $table->dropColumn('sick_75_84');
            $table->dropColumn('healed_75_84');
            $table->dropColumn('dead_75_84');

            //Tranche d'age >=85
            $table->dropColumn('confirmed_85');
            $table->dropColumn('sick_85');
            $table->dropColumn('healed_85');
            $table->dropColumn('dead_85');
            $table->dropColumn('occupied_Beds');
            $table->dropColumn('occupied_respirators');
            $table->dropColumn('masks');
            $table->dropColumn('occupied_foam_beds');
            $table->dropColumn('occupied_resuscitation_beds');
            $table->dropColumn('individual_protection_equipment');
            $table->dropColumn('gel_hydro_alcoolique');
            $table->dropColumn('resuscitation_ventilator');
            $table->dropColumn('oxygenator');
            $table->dropColumn('rapid_screening');
            $table->dropColumn('automate_genexpert');
            $table->dropColumn('x_ray');
            $table->dropColumn('check_point');
            $table->dropColumn('chloroquine');
            $table->dropColumn('hydrochloroquine');
            $table->dropColumn('azytromicine');
            $table->dropColumn('Vitamince_c');
        });
    }
}
