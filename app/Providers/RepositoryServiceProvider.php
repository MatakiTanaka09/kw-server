<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use KW\Domain\Models\Book\BookRepositoryInterface;
use KW\Infrastructure\Repositories\Domain\Eloquent\Book\EloquentBookRepository;

use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;
use KW\Infrastructure\Repositories\Domain\Eloquent\EventDetail\EloquentEventDetailRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDomainRepository();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerDomainRepository()
    {
        $this->app->bind(BookRepositoryInterface::class, EloquentBookRepository::class);
        $this->app->bind(EventDetailRepositoryInterface::class, EloquentEventDetailRepository::class);
    }
}
