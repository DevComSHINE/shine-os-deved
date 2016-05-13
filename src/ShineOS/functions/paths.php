<?php

function userfiles_path()
{
    static $folder;
    if (!$folder) {
        $folder = normalize_path(base_path() . DIRECTORY_SEPARATOR . SHINEOS_USERFILES_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function userfiles_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url() . SHINEOS_USERFILES_FOLDER_NAME . DIRECTORY_SEPARATOR;
    }
    return $folder;
}

function media_base_url()
{
    static $folder;
    if (!$folder) {
        $folder = userfiles_url() . (SHINEOS_MEDIA_FOLDER_NAME . '/');
    }
    return $folder;
}

function media_base_path()
{
    static $folder;
    if (!$folder) {
        $folder = userfiles_path() . (SHINEOS_MEDIA_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function upload_base_path()
{
    static $folder;
    if (!$folder) {
        $folder = userfiles_path() . (SHINEOS_UPLOADS_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}


function modules_path()
{
    static $folder;
    if (!$folder) {
        $folder = normalize_path(base_path() . DIRECTORY_SEPARATOR . SHINEOS_MODULES_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function plugins_path()
{
    static $folder;
    if (!$folder) {
        $folder = normalize_path(base_path() . DIRECTORY_SEPARATOR . SHINEOS_PLUGINS_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function widgets_path()
{
    static $folder;
    if (!$folder) {
        $folder = normalize_path(base_path() . DIRECTORY_SEPARATOR . SHINEOS_WIDGETS_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function elements_path()
{
    static $folder;
    if (!$folder) {
        $folder = (userfiles_path() . SHINEOS_ELEMENTS_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function uploads_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url(SHINEOS_USERFILES_FOLDER_NAME. DIRECTORY_SEPARATOR .SHINEOS_UPLOADS_FOLDER_NAME . DIRECTORY_SEPARATOR);

    }
    return $folder;
}

function modules_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url(SHINEOS_USERFILES_FOLDER_NAME . '/' . SHINEOS_MODULES_FOLDER_NAME . '/');
    }
    return $folder;
}

function plugins_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url(SHINEOS_USERFILES_FOLDER_NAME . '/' . SHINEOS_PLUGINS_FOLDER_NAME . '/');
    }
    return $folder;
}

function widgets_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url(SHINEOS_USERFILES_FOLDER_NAME . '/' . SHINEOS_WIDGETS_FOLDER_NAME . '/');
    }
    return $folder;
}


function templates_path()
{
    static $folder;
    if (!$folder) {
        $folder = (userfiles_path() . SHINEOS_TEMPLATES_FOLDER_NAME . DIRECTORY_SEPARATOR);
    }
    return $folder;
}

function templates_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url(SHINEOS_USERFILES_FOLDER_NAME . '/' . SHINEOS_TEMPLATES_FOLDER_NAME . '/');
    }
    return $folder;
}


function admin_url($add_string = false)
{


    return site_url() . '/' . $add_string;
}


//Microweber system


function shineos_cache_path()
{
    return storage_path() . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
}

function shineos_includes_url()
{
    static $folder;
    if (!$folder) {
        $folder = site_url() . 'public/dist/';
    }
    return $folder;
}

function shineos_includes_path()
{
    static $folder;
    if (!$folder) {
        $folder = modules_path() . SHINEOS_SYSTEM_MODULE_FOLDER . '/assets/';
    }
    return $folder;
}

function shineos_root_path()
{
    static $folder;
    if (!$folder) {
        $folder = public_path();
    }
    return $folder;
}
