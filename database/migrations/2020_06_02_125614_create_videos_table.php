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
            $table->uuid('id')->primary();
            $table->string('origin')->nullable();
            $table->string('notification_id')->nullable();
            $table->string('creation')->nullable();
            $table->string('title');
            $table->string('thumb')->nullable();
            $table->time('duration', 0)->nullable();
            $table->boolean('visibility')->default(true);
            $table->string('subtitles')->nullable();
            $table->json('sources')->nullable();
            $table->json('presentation')->nullable();
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
