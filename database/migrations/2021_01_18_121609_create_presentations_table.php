<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->string('local');
            $table->string('base');
            $table->string('title');
            $table->string('presenters');
            $table->integer('created');
            $table->integer('duration');
            $table->string('courses');
            $table->string('tags');
            $table->string('thumb')->nullable();
            $table->string('permission');
            $table->string('entitlement');
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
        Schema::dropIfExists('presentations');
    }
}
