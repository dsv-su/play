<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityToMediasite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mediasite_presentations', function (Blueprint $table) {
            $table->boolean('visibility')->default(1)->after('title');
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
            $table->dropColumn('visibility');
        });
    }
}
