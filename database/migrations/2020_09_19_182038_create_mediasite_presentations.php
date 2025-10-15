<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasitePresentations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediasite_presentations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->nullable();
            $table->string('user')->nullable();
            $table->uuid('video_id');
            $table->foreignId('mediasite_folder_id')->constrained();
            $table->string('title')->nullable();
            $table->string('presenters')->nullable();
            $table->integer('created')->nullable();
            $table->integer('duration')->nullable();
            $table->string('courses')->nullable();
            $table->string('tags')->nullable();
            $table->string('thumb')->nullable();
            $table->json('sources')->nullable();
           // $table->id();
          //  $table->text('name');
           // $table->text('mediasite_id');
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
        Schema::dropIfExists('mediasite_presentations');
    }
}
