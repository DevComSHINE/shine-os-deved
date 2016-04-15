<?php 
namespace Shine\Repositories\Contracts;

/**
 * The UserRepositoryInterface contains ONLY method signatures for methods 
 * related to the User object.
 *
 * Note that we extend from RepositoryInterface, so any class that implements 
 * this interface must also provide all the standard eloquent methods (find, all, etc.)
 */
interface UserRepositoryInterface extends BaseRepositoryInterface {
	public function findByUserID($id);
	public function findByColumn($column);
	public function findUserContactByID($id);
	public function findUserByFacilityUserID($id);
	// public function findAllFacilitiesByUserID();
	// public function findAllPatientsByUserID();
}