<?php

/* Functions for Patients */

use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\FacilityPatientUser;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;

    /**
     * Get a patient record using Patient ID
     * @param  [string] $id        patient_id
     * @param  [string] $attribute modelObject name
     * @return mixed
     */
    function findPatientByPatientID($id)
    {
        return patients::where('patient_id', '=', $id)->first();
    }

    /**
     * Get complete patient record including all related information
     * Alerts; Allergies; Disabilities; Contact; DeathInfo
     * using Patient ID
     * @param  [string] $id Patient ID
     * @return [array] Complete Patient record
     */
    function getCompletePatientByPatientID($id)
    {
        return Patients::with('patientAlert','patientAllergies','patientMedicalHistory','patientDisabilities','patientContact','patientDeathInfo','patientEmergencyInfo')->where('patient_id','=', $id)->first();
    }

    function getAllCompletePatientsByFacility($order = NULL, $dir = 'asc')
    {
        $facilityInfo = FacilityHelper::facilityInfo();

        $sql = "patients.deleted_at IS NULL";

        if($order) {
            $sql .= ' order by patients.'.$order.' '.$dir;
        }

        $patients = Patients::with('patientContact','facilityUser','patientDeathInfo')
            ->whereHas('facilityUser', function($query) use ($facilityInfo) {
                $query->where('facility_id', '=', $facilityInfo->facility_id);
            })
            ->whereRaw( $sql )
            ->get();

        return $patients;
    }

    /**
     * Get all patients of the Facility of current user
     * @return [array] Array of patient records
     *
     * WE NEED TO FIX THIS USING NORMALIZED VIEW
     */

    function getAllPatientsByFacility($order = NULL, $search = NULL, $dir = NULL, $limit = NULL, $offset = NULL)
    {
        $facilityInfo = FacilityHelper::facilityInfo();

        /*$arg = "select *, `patients`.`patient_id` as PID from `patients` LEFT JOIN `patient_contact` ON `patient_contact`.`patient_id` = `patients`.`patient_id` LEFT JOIN `patient_death_info` ON `patient_death_info`.`patient_id` = `patients`.`patient_id` LEFT JOIN `patient_familyinfo` ON `patient_familyinfo`.`patient_id` = `patients`.`patient_id` INNER JOIN `facility_patient_user` on `patients`.`patient_id` = `facility_patient_user`.`patient_id` INNER JOIN `facility_user` on `facility_user`.`facilityuser_id` = `facility_patient_user`.`facilityuser_id` where `patients`.`deleted_at` is null ";*/

        $sql = " `deleted_at` is null AND `facility_id` = '".$facilityInfo->facility_id."'";

        if($search) {
            $sql .= ' AND (`first_name` LIKE "%'.$search.'%" OR `last_name` LIKE "%'.$search.'%" OR `middle_name` LIKE "%'.$search.'%" OR `birthdate` LIKE "%'.$search.'%")';
        }

        if($order){
            if($order == 'barangay'){
                $sql .= ' order by `patient_contact`.`'.$order.'` '.$dir;
            } elseif($order == 'family_folder_name'){
                $sql .= ' order by `patient_familyinfo`.`'.$order.'` '.$dir;
            } else {
                $sql .= ' order by `'.$order.'` '.$dir;
            }
        }
        if($limit) {
            $sql .= ' limit '.$limit;
            if($offset) {
                $sql .= ' offset '.$offset;
            }
        }

        $patients = DB::table('patients_view')
            ->whereRaw( $sql )
            ->get();

        return $patients;
    }

    /**
     * Count all patients of the Facility of current user
     * @return [int] Count of patient records
     */
    function countAllPatientsByFacility()
    {
        $facilityInfo = FacilityHelper::facilityInfo();

        $patients = DB::table('patients_view')
            ->where('facility_id', '=', $facilityInfo->facility_id)
            ->where('deleted_at','=',NULL)
            ->get();

        return count($patients);
    }

    function getPatientIDByHealthcareserviceID($id)
    {
        $hc_service = Healthcareservices::where('healthcareservice_id','=',$id)->first();
        $facilitypatientuser_id = $hc_service->facilitypatientuser_id;
        $facility_patient_user = FacilityPatientUser::where('facilitypatientuser_id','=',$facilitypatientuser_id)->first();
        $patient_id = $facility_patient_user->patient_id;
        return $patient_id;
    }
