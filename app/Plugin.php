<?php

namespace Shine;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
   	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'plugins';
    protected static $table_name = 'plugins';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'plugin_id';
}
