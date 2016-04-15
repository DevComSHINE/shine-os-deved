<?php


function api_expose($function_name, $callback = null)
{
    static $index = ' ';
    if (is_bool($function_name)) {
        return $index;
    }
    if (is_callable($callback)) {
        $index .= ' ' . $function_name;
        return api_bind($function_name, $callback);
    } else {
        $index .= ' ' . $function_name;
    }
}

function api_expose_admin($function_name, $callback = null)
{
    static $index = ' ';
    if (is_bool($function_name)) {
        return $index;
    }
    if (is_callable($callback)) {
        $index .= ' ' . $function_name;
        return api_bind_admin($function_name, $callback);
    } else {
        $index .= ' ' . $function_name;
    }
}


function api_bind($function_name, $callback = false)
{
    static $shineos_api_binds;
    if (is_bool($function_name)) {
        if (is_array($shineos_api_binds)) {
            $index = ($shineos_api_binds);
            return $index;
        }

    } else {
        $function_name = trim($function_name);
        $shineos_api_binds[$function_name][] = $callback;

    }
}

function api_bind_admin($function_name, $callback = false)
{
    static $shineos_api_binds;
    if (is_bool($function_name)) {
        if (is_array($shineos_api_binds)) {
            $index = ($shineos_api_binds);
            return $index;
        }

    } else {
        $function_name = trim($function_name);
        $shineos_api_binds[$function_name][] = $callback;

    }
}

function document_ready($function_name)
{
    static $index = ' ';
    if (is_bool($function_name)) {

        return $index;
    } else {
        $index .= ' ' . $function_name;
    }
}

function execute_document_ready($l)
{

    $document_ready_exposed = (document_ready(true));

    if ($document_ready_exposed != false) {
        $document_ready_exposed = explode(' ', $document_ready_exposed);
        $document_ready_exposed = array_unique($document_ready_exposed);
        $document_ready_exposed = array_trim($document_ready_exposed);

        foreach ($document_ready_exposed as $api_function) {
            if (function_exists($api_function)) {
                $l = $api_function($l);
            }
        }
    }

    return $l;
}


function array_to_module_params($params, $filter = false)
{
    $str = '';
    if (is_array($params)) {
        foreach ($params as $key => $value) {

            if ($filter == false) {
                $str .= $key . '="' . $value . '" ';
            } else if (is_array($filter) and !empty($filter)) {
                if (in_array($key, $filter)) {
                    $str .= $key . '="' . $value . '" ';
                }
            } else {
                if ($key == $filter) {
                    $str .= $key . '="' . $value . '" ';
                }
            }

        }
    }
    return $str;
}


function parse_params($params)
{
    $params2 = array();
    if (is_string($params)) {
        $params = parse_str($params, $params2);
        $params = $params2;
        unset($params2);
    }
    return $params;
}

// stores vars in memory
function shineos_var($key, $new_val = false)
{
    static $shineos_var_storage;
    $contstant = ($key);
    if ($new_val == false) {
        if (isset($shineos_var_storage[$contstant]) != false) {
            return $shineos_var_storage[$contstant];
        } else {
            return false;
        }
    } else {
        if (isset($shineos_var_storage[$contstant]) == false) {
            $shineos_var_storage[$contstant] = $new_val;
            return $new_val;
        }
    }
    return false;
}


function autoload_add($dirname)
{
    set_include_path($dirname .
        PATH_SEPARATOR . get_include_path());
}


function api_link($str = '')
{
    return shine()->url_manager->api_link($str);

}
