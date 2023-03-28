<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityToManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->boolean('visibility')->default(true)->after('duration');
            $table->boolean('unlisted')->default(false)->after('visibility');
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
            $table->dropColumn('visibility');
            $table->dropColumn('unlisted');
        });
    }
}
