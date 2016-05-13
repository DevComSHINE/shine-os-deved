<?php

namespace Shine\Console\Commands;

use Illuminate\Console\Command;
use Shine\Plugin;
use DB;

class SavePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shine:saveplugin {plugin} {facilityId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store plugin id and name to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('plugin');
        $facilityId = $this->argument('facilityId');
        $config = config($name);

        $plugin = new Plugin;
        $plugin->facility_id = $facilityId;
        $plugin->plugin_name = $config['name'];
        $plugin->plugin_id = $config['id'];
        $plugin->save();

        if ($plugin->save()) :
            $this->comment(PHP_EOL.$name." has been saved successfully!".PHP_EOL);
        else:
            $this->comment(PHP_EOL."An error has occurred while saving your plugin. Kindly try again.".PHP_EOL);
        endif;

    }
}
