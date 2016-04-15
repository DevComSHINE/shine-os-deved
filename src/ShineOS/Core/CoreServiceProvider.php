<?php namespace ShineOS\Core;

use Illuminate\Support\ServiceProvider;
use \View;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $cores = config("core.core");
        while (list(,$core) = each($cores)) {
            if(file_exists(__DIR__.'/'.$core.'/Http/routes.php')) {
                include __DIR__.'/'.$core.'/Http/routes.php';
            }

            $this->registerConfig($core);
            $this->registerViews($core);
            $this->registerTranslations($core);

        }

    }
    public function register(){

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig($core)
    {
        $this->publishes([
            __DIR__.'/'.$core.'/Config/config.php' => config_path($core.'.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/'.$core.'/Config/config.php', $core
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews($core)
    {
        View::addNamespace(strtolower($core), 'src/ShineOS/Core/'.ucfirst($core).'/Resources/views');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations($core)
    {
        $langPath = base_path('resources/lang/modules/'.$core);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $core);
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/'.$core.'/Resources/lang', $core);
        }
    }
}
