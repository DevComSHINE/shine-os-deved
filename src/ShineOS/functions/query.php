<?php

/*
 * Methods related to Database Queries
 *
 * @package ShineOS+
 * @subpackage Query
 * @version 3.0
 *
*/

/**
 * Get records from a given table
 * @param  string   $tableName  Table Name
 * @param  array    $column     an array of column names
 * @param string   $returnType Data type to return
 * @return multiple             data in array or as specified by returnType
 */
function findByTable($tableName, $column = array('*'), $returnType = NULL)
{
    $result = DB::table($tableName)->select('*')->where($column)->get();

    return $result;
}
