<?php

namespace ShineOS;

/**
 * Application class
 *
 * Class that loads other classes
 *
 * @package  Application
 * @category Application
 * @desc
 *
 */
class Application {

    public static $instance;

    public function __construct($params = null) {
        $instance       = app();
        self::$instance = $instance;

        return self::$instance;
    }

    public static function getInstance($params = null) {
        if (self::$instance==null){
            self::$instance = app();
        }

        return self::$instance;
    }

    public function make($property) {
        return app()->make($property);
    }

    public function __get($property) {
        return $this->make($property);
    }
}
