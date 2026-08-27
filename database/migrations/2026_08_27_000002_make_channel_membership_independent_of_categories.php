<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Upgrade installations that applied the first version of the channel
        // assignment migration. Fresh installations already have this shape.
        if (! Schema::hasTable('channel_video_assignments')) {
            return;
        }

        $indexes = collect(Schema::getIndexes('channel_video_assignments'));
        $hasVideoIndex = $indexes->contains(fn (array $index) => $index['columns'] === ['video_id'] && ! $index['unique']);

        // The video FK needs an index of its own before MariaDB will allow the
        // old unique video_id index to be removed.
        if (! $hasVideoIndex) {
            Schema::table('channel_video_assignments', function (Blueprint $table) {
                $table->index('video_id');
            });
        }

        $indexes = collect(Schema::getIndexes('channel_video_assignments'));
        if ($indexes->contains(fn (array $index) => $index['name'] === 'channel_video_assignments_video_id_unique')) {
            Schema::table('channel_video_assignments', function (Blueprint $table) {
                $table->dropUnique(['video_id']);
            });
        }

        $foreignKeys = collect(Schema::getForeignKeys('channel_video_assignments'));
        if ($foreignKeys->contains(fn (array $foreign) => $foreign['name'] === 'channel_video_assignments_previous_category_id_foreign')) {
            Schema::table('channel_video_assignments', function (Blueprint $table) {
                $table->dropForeign(['previous_category_id']);
            });
        }

        if (Schema::hasColumn('channel_video_assignments', 'previous_category_id')) {
            Schema::table('channel_video_assignments', function (Blueprint $table) {
                $table->dropColumn('previous_category_id');
            });
        }

        $indexes = collect(Schema::getIndexes('channel_video_assignments'));
        if (! $indexes->contains(fn (array $index) => $index['columns'] === ['channel_id', 'video_id'] && $index['unique'])) {
            Schema::table('channel_video_assignments', function (Blueprint $table) {
                $table->unique(['channel_id', 'video_id']);
            });
        }
    }

    public function down(): void
    {
        // Category restoration was part of the obsolete category-changing
        // implementation and cannot be reconstructed reliably.
    }
};
