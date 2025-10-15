<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseadminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courseadmin_permissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('video_id');
            $table->foreign('video_id')->references('id')->on('videos');
            $table->string('username')->nullable();
            $table->string('name')->nullable();
            $table->string('permission');
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
        Schema::dropIfExists('courseadmin_permissions');
    }
}
