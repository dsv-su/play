<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBaseManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->renameColumn('base', 'upload_dir')
                ->after('local');
            $table->json('generate_subtitles')->after('sources');
            $table->json('subtitles')->change();
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
            $table->renameColumn('upload_dir', 'base');
            $table->dropColumn('generate_subtitles');
        });
    }
}
