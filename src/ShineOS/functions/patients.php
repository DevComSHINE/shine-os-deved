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
        return Patients::with('patientAlert','patientAllergies','patientDisabilities','patientContact','patientDeathInfo','patientEmergencyInfo')->where('patient_id','=', $id)->first();
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

        $arg = "select *, `patients`.`patient_id` as PID from `patients` LEFT JOIN `patient_contact` ON `patient_contact`.`patient_id` = `patients`.`patient_id` LEFT JOIN `patient_death_info` ON `patient_death_info`.`patient_id` = `patients`.`patient_id` LEFT JOIN `patient_familyinfo` ON `patient_familyinfo`.`patient_id` = `patients`.`patient_id` where `patients`.`deleted_at` is null and (select count(*) from `facility_user` inner join `facility_patient_user` on `facility_user`.`facilityuser_id` = `facility_patient_user`.`facilityuser_id`";

        $sql = " where `facility_patient_user`.`patient_id` = `patients`.`patient_id` and `facility_id` = ".$facilityInfo->facility_id.")";

        if($search) {
            $sql .= ' AND (`patients`.`first_name` LIKE "%'.$search.'%" OR `patients`.`last_name` LIKE "%'.$search.'%" OR `patients`.`middle_name` LIKE "%'.$search.'%" OR `patients`.`birthdate` LIKE "%'.$search.'%")';
        }

        if($order){
            if($order == 'barangay'){
                $sql .= ' order by `patient_contact`.`'.$order.'` '.$dir;
            } elseif($order == 'family_folder_name'){
                $sql .= ' order by `patient_familyinfo`.`'.$order.'` '.$dir;
            } else {
                $sql .= ' order by `patients`.`'.$order.'` '.$dir;
            }
        }
        if($limit) {
            $sql .= ' limit '.$limit;
            if($offset) {
                $sql .= ' offset '.$offset;
            }
        }

        $patients = DB::select( $arg.$sql );

        return $patients;
    }

    /**
     * Count all patients of the Facility of current user
     * @return [int] Count of patient records
     */
    function countAllPatientsByFacility()
    {
        $facilityInfo = FacilityHelper::facilityInfo();

        $patients = DB::table('patients')
            ->join('facility_patient_user', 'facility_patient_user.patient_id','=','patients.patient_id')
            ->join('facility_user','facility_user.facilityuser_id','=','facility_patient_user.facilityuser_id')
            ->where('facility_user.facility_id', '=', $facilityInfo->facility_id)
            ->where('patients.deleted_at','=',NULL)
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

    /**
     * Transfer to reports
     * @return [type] [description]
     */
    function getDiseases()
    {
        $diseases = ['Acute Watery Diarrhea'=>'A09',
        'Acute Bloody Diarrhea'=>'A09',
        'Inluenza-like Illness'=>'J11',
        'Influenza'=>'J11',
        'Acute Flaccid Paralysis'=>'G83.9',
        'Acute Hemorrhagic Fever Syndrome'=>'A91',
        'Acute Lower Respiratory Track Infection'=>'J22',
        'Pneumonia'=>'J18.9',
        'Cholera'=>'A00',
        'Diphtheria'=>'A36',
        'Filarisis'=>'B74',
        'Leprosy'=>'A30',
        'Leptospirosis'=>'A27',
        'Malaria'=>'B50-B54',
        'Measles'=>'B05',
        'Meningococcemia'=>'A39',
        'Neonatal Tetanus'=>'A33',
        'Non-neonatal Tetanus'=>'A35',
        'Paralytic Shellfish Poisoning'=>'T61.2',
        'Rabies'=>'A82',
        'Schistosomiasis'=>'B65',
        'Typhoid'=>'A01',
        'Paratyphoid'=>'A01',
        'Viral Encephalitis'=>'A83-86',
        'Acute Viral Hepatitis'=>'B15-B17',
        'Viral Meningitis'=>'A87',
        'Syphilis'=>'A50-A53',
        'Gonorrhea'=>'A54.9',
        'Urethral Discharge'=>'R36',
        'Genital Ulcer'=>'N48.5'
        ];

        return $diseases;
    }

    function getAgeGroups()
    {
        $ageGroup = ['Under 1' => '0-1',
        '1 to 4' => '1-4',
        '5 to 9' => '5-9',
        '10 to 14' => '10-14',
        '15 to 19' => '15-19',
        '20 to 24' => '20-24',
        '25 to 29' => '25-29',
        '30 to 34' => '30-34',
        '35 to 39' => '35-39',
        '40 to 44' => '40-44',
        '45 to 49' => '45-49',
        '50 to 54' => '50-54',
        '55 to 59' => '55-59',
        '60 to 64' => '60-64',
        '65 to 59' => '65-69',
        '70+' => '70-100'
        ];

        return $ageGroup;
    }
