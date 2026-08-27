<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MariaDB can leave the table behind when adding a foreign key fails.
        // This migration is not recorded in that case, so remove only that
        // incomplete table before retrying it.
        Schema::dropIfExists('channel_video_assignments');

        Schema::create('channel_video_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained()->cascadeOnDelete();
            // videos.id was created as CHAR(36). Laravel's MariaDB grammar
            // otherwise emits a native UUID column, which cannot reference it.
            $table->char('video_id', 36);
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
            $table->string('assigned_by');
            $table->timestamps();
            $table->unique(['channel_id', 'video_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channel_video_assignments');
    }
};
