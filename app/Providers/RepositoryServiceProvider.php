<?php namespace Shine\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    //protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBaseRepo();
        $this->registerUserRepo();
        $this->registerFacilityRepo();
    }

    public function registerBaseRepo()
    {
        $this->app->bind('Shine\Repositories\Contracts\BaseRepositoryInterface','Shine\Repositories\Eloquent\BaseRepository');
    }

    public function registerUserRepo()
    {
        $this->app->bind('Shine\Repositories\Contracts\UserRepositoryInterface', 'Shine\Repositories\Eloquent\UserRepository');
    }

    public function registerFacilityRepo()
    {
        $this->app->bind('Shine\Repositories\Contracts\FacilityRepositoryInterface', 'Shine\Repositories\Eloquent\FacilityRepository');
    }
}