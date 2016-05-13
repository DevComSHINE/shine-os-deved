<?php

use Shine\Libraries\Utils\Lovs;

/*
 * Methods related to Lovs
 *
 * @package ShineOS+
 * @subpackage Lovs
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
function getLabName($code)
{
    $result = Lovs::getValueOfFieldBy('laboratories', 'laboratorydescription', 'laboratorycode', $code);

    return $result;
}
