<?php

namespace App\Providers;

use App\Repositories\TreeRepository;
use App\Services\GitHubService;
use App\Services\TreeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public $bindings = [
        TreeRepository::class => TreeRepository::class,
        TreeService::class=> TreeService::class
    ];
}
