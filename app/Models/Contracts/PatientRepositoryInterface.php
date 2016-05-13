<?php 
namespace Shine\Repositories\Contracts;

/**
 * The PatientRepositoryInterface contains ONLY method signatures for methods 
 * related to the Patient object.
 *
 * Note that we extend from RepositoryInterface, so any class that implements 
 * this interface must also provide all the standard eloquent methods (find, all, etc.)
 */
interface PatientRepositoryInterface extends BaseRepositoryInterface {
	/**
	 * Dynamic Query based on attribute
	 * 
	 * @param  [string] $id         patient_id
	 * @param  [string] $attribute  modelObject name
	 *    Can return: 
	 *    Alert   - PatientAlert
	 *    Contact - PatientContacts [Contact information of the patient]
	 *    Death Information  - PatientDeathInfo [Information regarding the cause of death of the patient]
	 *    Emergency Information  - PatientEmergencyInfo
	 *    Employment Information  - PatientEmploymentInfo
	 *    Family Information  - PatientFamilyInfo
	 *    Family Medical History  - PatientMedicalHistory
	 *    Family Planning Counseling - PatientFPCounseling
	 *    Immunization History - PatientImmunizationHistory
	 *    Immunization - PatientImmunization
	 *    Medical History - PatientMedicalHistory
	 *    Menstrual History - PatientMenstrual
	 *    Personal History - PatientPersonalHistory
	 *    PhilHealth Information - PatientPhilhealthInfo
	 *    Pregnancy History - PatientPregnancyHistory
	 *    Surgical History - PatientSurgicalHistory
	 * @return mixed
	 */
	public function findByPatientID($id, $attribute); // e.g Patient ID: 00001, Get Employment Info (TABLE NAME)
	// public function findByPatientName($surname= NULl, $firstname);
	// public function findAllByPatientName($surname, $firstname);
}