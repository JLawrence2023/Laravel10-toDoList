<?php

namespace App\Providers;

use App\Contracts\TaskContract;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * The repository mappings for the application.
     *
     * @var array
     */
    protected array $repositories = [
        TaskContract::class => TaskRepository::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }
}
