<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToOther extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mediasite_presentations', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
        Schema::table('presentations', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mediasite_presentations', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('presentations', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
