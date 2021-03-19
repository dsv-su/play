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
            $table->id();
            $table->text('name');
            $table->text('mediasite_id');
            $table->foreignId('mediasite_folder_id')->constrained();
            $table->uuid('video_id');
            $table->integer('status')->nullable();
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
