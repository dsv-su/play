<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDownloadToVideoStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_stats', function (Blueprint $table) {
            $table->integer('download')->nullable();
            $table->renameColumn('stats', 'playback');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_stats', function (Blueprint $table) {
            $table->dropColumn('download');
        });
    }
}
