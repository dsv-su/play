<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogToManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->uuid('jobid')->after('id');
            $table->boolean('autogenerate_subtitles')->default(false)->after('subtitles');
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
            $table->dropColumn('jobid');
            $table->dropColumn('autogenerate_subtitles');
        });
    }
}
