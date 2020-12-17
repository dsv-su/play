<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_presentations', function (Blueprint $table) {
            $table->id();
            $table->string('base');
            $table->string('title');
            $table->string('presenters');
            $table->date('created');
            $table->time('duration', 0);
            $table->string('courses');
            $table->string('tags');
            $table->string('thumb');
            $table->json('sources');
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
        Schema::dropIfExists('manual_presentations');
    }
}
