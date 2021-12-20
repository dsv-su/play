<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCoursesManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('manual_presentations', function (Blueprint $table) {
            $table->json('daisy_courses')->after('courses');
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
            $table->dropColumn('daisy_courses');
        });
    }
}
