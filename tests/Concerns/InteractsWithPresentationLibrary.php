<?php

namespace Tests\Concerns;

use App\Repositories\EloquentVideoRepository;
use App\Services\Filters\VisibilityFilter;
use App\Services\MyPresentation\MyPresentationsService;
use App\Services\MyPresentation\PresentationLibrary;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;

trait InteractsWithPresentationLibrary
{
    private PresentationLibrary $library;

    private MyPresentationsService $membership;

    protected function setUp(): void
    {
        parent::setUp();
        // Isolated schema: these tests never touch the configured application database.
        config(['database.default' => 'library_test', 'database.connections.library_test' => [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '',
        ]]);
        $this->app->instance('play_username', 'alice');
        $this->app->instance('play_auth', 'Student');
        $this->app->instance('play_role', 'Student');
        Schema::create('videos', function (Blueprint $t) {
            $t->string('id')->primary();
            $t->boolean('state')->default(true);
            $t->boolean('visibility')->default(true);
            $t->integer('creation');
            $t->string('thumb')->default('thumb.jpg');
            $t->string('title')->default('A presentation');
            $t->string('title_en')->nullable();
            $t->integer('category_id')->default(1);
        });
        Schema::create('courses', function (Blueprint $t) {
            $t->integer('id')->primary();
            foreach (['designation', 'semester', 'year', 'name', 'name_en'] as $column) {
                $t->string($column);
            }
            $t->boolean('state')->default(true);
            $t->boolean('visibility')->default(true);
        });
        foreach (['video_courses' => 'course_id', 'video_tags' => 'tag_id', 'video_presenters' => 'presenter_id', 'video_permissions' => 'permission_id'] as $table => $foreign) {
            Schema::create($table, function (Blueprint $t) use ($foreign) {
                $t->increments('id');
                $t->string('video_id');
                $t->integer($foreign);
                $t->timestamps();
            });
        }
        foreach (['individual_permissions', 'courseadmin_permissions', 'coursesettings_users'] as $table) {
            Schema::create($table, function (Blueprint $t) use ($table) {
                $t->increments('id');
                $table === 'coursesettings_users' ? $t->integer('course_id') : $t->string('video_id');
                $t->string('username');
                $t->string('permission')->default('view');
            });
        }
        Schema::create('tags', function (Blueprint $t) {
            $t->integer('id');
            $t->string('name');
        });
        Schema::create('presenters', function (Blueprint $t) {
            $t->integer('id');
            $t->string('username');
            $t->string('name');
        });
        Schema::create('categories', function (Blueprint $t) {
            $t->integer('id');
            $t->string('category_name');
        });
        DB::table('categories')->insert(['id' => 1, 'category_name' => 'Lecture']);
        Schema::create('pendings', function (Blueprint $t) {
            $t->string('video_id');
        });
        $this->membership = Mockery::mock(MyPresentationsService::class)->makePartial();
        $this->membership->shouldReceive('resolveCourseIds')->andReturn([42]);
        $this->membership->shouldReceive('resolveIndividualVideoIds')->andReturn(['orphan']);
        $this->library = new PresentationLibrary($this->membership, new EloquentVideoRepository, new VisibilityFilter);
        $this->app->instance(PresentationLibrary::class, $this->library);
        DB::table('courses')->insert([
            ['id' => 42, 'designation' => 'ABC', 'semester' => 'HT', 'year' => '2026', 'name' => 'Kurs', 'name_en' => 'Course'],
            ['id' => 43, 'designation' => 'DEF', 'semester' => 'VT', 'year' => '2025', 'name' => 'Annan', 'name_en' => 'Other'],
        ]);
        for ($i = 1; $i <= 45; $i++) {
            $this->video((string) $i, 42, $i);
        }
        $this->video('orphan', null, 100);
        DB::table('individual_permissions')->insert(['video_id' => 'orphan', 'username' => 'alice']);
    }

    private function video(string $id, ?int $course, int $creation, bool $visible = true, bool $state = true): void
    {
        DB::table('videos')->insert(['id' => $id, 'creation' => $creation, 'visibility' => $visible, 'state' => $state]);
        if ($course !== null) {
            DB::table('video_courses')->insert(['video_id' => $id, 'course_id' => $course]);
        }
    }
}
