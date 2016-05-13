<?php
namespace ShineOS\Install;

use ShineOS\Module;
use ShineOS\Utils\Database as DbUtils;
use Illuminate\Support\Facades\Schema as DbSchema;
use Illuminate\Support\Facades\Artisan;

use Cache;

class DbInstaller
{
    public function run($sql=NULL)
    {
        Cache::flush();
        $this->createSchema($sql);
        Cache::flush();
    }

    public function createSchema($sql=NULL)
    {
        if($sql){
            $seed = Artisan::call('db:seed', ['--class' => $sql]);
        } else {
            $migrate = Artisan::call('migrate');
        }

    }

    public function donothing()
    {
        return true;
    }

}
