<?php 
namespace Shine\Repositories\Contracts;

/**
 * BaseRepositoryInterface provides the standard functions to be expected of ANY 
 * repository.
 */
interface BaseRepositoryInterface {
	public function all($columns = array('*'), $returnType = NULL);
	public function paginate($perPage = 10, $columns = array('*'), $returnType = NULL);
	public function create(array $attributes);
	public function update(array $data, $id, $column="id");
	public function find($id, $columns = array('*'), $returnType = NULL);
	public function findBy($field, $value, $columns = array('*'), $returnType = NULL);
	public function findByName($surname= NULL, $firstname= NULL, $column= array('*'), $returnType = NULL);
	public function findAllByTable($tableName, $column = array('*'), $returnType = NULL);
	public function destroy($ids);
}