<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionToManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->string('permission')->after('thumb')->nullable();
            $table->string('entitlement')->after('permission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->dropColumn('permission');
            $table->dropColumn('entitlement');
        });
    }
}
