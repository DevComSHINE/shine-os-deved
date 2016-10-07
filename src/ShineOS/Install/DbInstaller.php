<?php
namespace ShineOS\Install;

use ShineOS\Module;
use ShineOS\Utils\Database as DbUtils;
use Illuminate\Support\Facades\Schema as DbSchema;
use Illuminate\Support\Facades\Artisan;
use DB, Cache, Schema;

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

    public function mysqlviews()
    {
        $runsql = "shineosviews.sql";
        $builder = new DbUtils();

        $shineos_sql = base_path() . DS . 'Database' . DS . $runsql;

        $builder->import_sql_file($shineos_sql);
    }

    public function donothing()
    {
        return true;
    }

}
