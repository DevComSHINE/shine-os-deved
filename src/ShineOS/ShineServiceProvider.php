<?php

namespace ShineOS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ClassLoader;
use Illuminate\Foundation\AliasLoader;

use Illuminate\Http\Request;
use Illuminate\Config\FileLoader;
use Carbon\Carbon;

use \Cache;
use \App;
use \Redirect;
use \View;

if (!defined('SHINEOS_VERSION')){
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'bootstrap.php');
}

class ShineServiceProvider extends ServiceProvider {

    public function __construct($app) {
        ClassLoader::addDirectories(array(
            base_path() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'modules',
            __DIR__,
        ));

        ClassLoader::register();
        spl_autoload_register(array($this, 'autoloadModules'));

        parent::__construct($app);
    }

    public function register() {
        // Set environment

        if (!$this->app->runningInConsole()){
            $domain = $_SERVER['HTTP_HOST'];
            $this->app->detectEnvironment(function () use ($domain) {
                if (getenv('APP_ENV')){
                    return getenv('APP_ENV');
                }

                $domain = str_ireplace('www.', '', $domain);
                $domain = str_ireplace(':' . $_SERVER['SERVER_PORT'], '', $domain);

                return $domain;
            });
        }

        $this->app->instance('config', new Providers\ConfigSave($this->app));

        $this->app->singleton(
            'Illuminate\Cache\StoreInterface'
        );

        $this->app->singleton('url_manager', function ($app) {
            return new Providers\UrlManager($app);
        });


        $this->app->singleton('event_manager', function ($app) {
            return new Providers\Event($app);
        });
        $this->app->singleton('database_manager', function ($app) {
            return new Providers\DatabaseManager($app);
        });

    }

    public function boot(Request $request) {
        parent::boot();

        App::instance('path.public', base_path());

        // If installed load module functions and set locale
        if (shineos_is_installed()){

        } else {
            $this->commands('ShineOS\Commands\InstallCommand');
        }
        // Register routes
        $this->registerRoutes();
    }

    private function registerRoutes() {
        $routesFile = __DIR__ . '/routes.php';
        if (file_exists($routesFile)){
            include $routesFile;
            return true;
        }
        return false;
    }

    function autoloadModules($className) {
        $filename = modules_path() . $className . ".php";
        $filename = normalize_path($filename, false);

        if (!class_exists($className, false)){
            if (is_file($filename)){
                require_once $filename;
            }
        }
    }

}
