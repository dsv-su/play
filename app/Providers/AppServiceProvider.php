<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Tag;
use App\Models\Video;
use App\Observers\CourseObserver;
use App\Observers\TagObserver;
use App\Observers\VideoObserver;
use App\Repositories\EloquentVideoRepository;
use App\Repositories\VideoRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VideoRepositoryInterface::class, EloquentVideoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Video::observe(VideoObserver::class);
        Tag::observe(TagObserver::class);
        Course::observe(CourseObserver::class);
    }
}
