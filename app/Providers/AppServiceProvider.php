<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Broadcast;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    //    Broadcast::routes([
    //         'middleware' => ['web', 'auth:admin'],
    //     ]);

   Broadcast::routes(['middleware' => ['web', 'auth:web,admin']]);

    require base_path('routes/channels.php');




    }
}
