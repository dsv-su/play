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
            $table->string('presentation_id')->nullable();
            $table->string('title');
            $table->string('thumb')->nullable();
            $table->string('presenter')->nullable();
            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
            $table->string('subtitles')->nullable();
            $table->text('tags')->nullable();
            $table->json('presentation')->nullable();
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
