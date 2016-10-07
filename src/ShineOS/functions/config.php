<?php

function shineos_is_installed()
{
    static $is = false;

    if ($is == false) {
        $is = Config::get('shineos.is_installed');
    }
    return (bool)$is;
}
