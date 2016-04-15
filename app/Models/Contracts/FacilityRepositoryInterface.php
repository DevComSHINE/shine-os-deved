<?php 
namespace Shine\Repositories\Contracts;

/**
 * The FacilityRepositoryInterface contains ONLY method signatures for methods 
 * related to the Facility object.
 *
 * Note that we extend from RepositoryInterface, so any class that implements 
 * this interface must also provide all the standard eloquent methods (find, all, etc.)
 */
interface FacilityRepositoryInterface extends BaseRepositoryInterface {
	public function findByFacilityName($name, $returnType = NULL);
	public function findByFacilityID($id, $returnType = NULL);
	public function findFacilityByFacilityUserID($id, $returnType = NULL);
	public function findFacilityUserByFacilityID($id, $returnType = NULL);
	public function findPatientByFacilityPatientUserID($id, $returnType = NULL);
	public function findAllUsersByFacilityID($id, $limit, $returnType = NULL); 
	public function findAllPatientsByFacilityID($id, $limit, $returnType = NULL);
}