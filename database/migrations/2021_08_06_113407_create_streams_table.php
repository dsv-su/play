<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->uuid('video_id');
            $table->foreign('video_id')->references('id')->on('videos');
            $table->string('name')->nullable();
            $table->string('poster')->nullable();
            $table->boolean('audio')->default(0);
            $table->timestamps();
        });
        Schema::create('stream_resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stream_id')->constrained();
            $table->integer('resolution');
            $table->string('filename');
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
        Schema::dropIfExists('stream_resolutions');
        Schema::dropIfExists('streams');
    }
}
