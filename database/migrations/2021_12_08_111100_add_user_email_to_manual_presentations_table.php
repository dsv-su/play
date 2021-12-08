<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserEmailToManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->string('user_email')->after('user');
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
                $table->dropColumn('user_email');
        });
    }
}
