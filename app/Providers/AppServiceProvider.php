<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BlogRepositoryInterface::class,BlogRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
