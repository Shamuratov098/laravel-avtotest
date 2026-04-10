<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\QuestionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class,
        );

        $this->app->bind(
            QuestionRepositoryInterface::class,
            QuestionRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
