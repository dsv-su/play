<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesettingsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursesettings_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->boolean('visibility')->default(true);
            $table->boolean('downloadable')->default(false);
            $table->boolean('playback')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursesettings_permissions');
    }
}
