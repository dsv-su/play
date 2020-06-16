<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('length');
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->string('source1');
            $table->string('source2')->nullable();
            $table->string('source3')->nullable();
            $table->string('source4')->nullable();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('videos');
    }
}
