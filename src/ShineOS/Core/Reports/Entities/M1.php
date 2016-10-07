<?php
namespace ShineOS\Core\Reports\Entities;

use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use Plugins\MaternalCare\MaternalCareModel;
use App\Libraries\CSSColors;
use DB, Input, DateTime, Session;
use Illuminate\Database\Eloquent\Model;

class M1 extends Model {

    /**
     *  REUSABLE SCOPE HERE
     */

    public static function scopeDeliveries($month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_delivery` a
JOIN maternalcare b ON b.`maternalcase_id` = a.`maternalcase_id`
JOIN healthcare_services c ON c.healthcareservice_id = b.healthcareservice_id
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeIronSup($month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT TIMESTAMPDIFF(YEAR,i.birthdate,a.created_at) as 'age', g.facility_id, count(*) as 'count' FROM `maternalcare_supplements` a
JOIN maternalcare_prenatal b ON b.prenatal_id = a.`prenatal_id`
JOIN maternalcare d ON d.maternalcase_id = b.maternalcase_id
JOIN healthcare_services e ON e.healthcareservice_id = d.healthcareservice_id
JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id
JOIN patients i ON i.patient_id = f.patient_id
WHERE g.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND `supplement_type` = 2
AND 'age' > 10 AND 'age' < 49
GROUP BY g.facility_id";

        $val = DB::select( DB::raw( $sql ));
        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }


    public static function scopeBFeeding($month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_delivery` a
JOIN maternalcare_postpartum x ON x.maternalcase_id = a.maternalcase_id
JOIN maternalcare b ON b.`maternalcase_id` = a.`maternalcase_id`
JOIN healthcare_services c ON c.healthcareservice_id = b.healthcareservice_id
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE e.facility_id = '$facility->facility_id'
AND HOUR(x.created_at) - HOUR(a.`created_at`) < 1
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));
        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopePPVitA($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_supplements` a
    JOIN maternalcare_postpartum b ON b.postpartum_id = a.postpartum_id
    JOIN maternalcare d ON d.maternalcase_id = b.maternalcase_id
    JOIN healthcare_services e ON e.healthcareservice_id = d.healthcareservice_id
    JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
    JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
    JOIN facilities h ON h.facility_id = g.facility_id
    JOIN patients i ON i.patient_id = f.patient_id
    WHERE g.facility_id = '$facility->facility_id'
    AND `supplement_type` = 1
    AND MONTH(a.created_at) = $month
    AND YEAR(a.created_at) = $year
    GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = $val[0]->count;
        }

        return $t;
    }

    public static function scopePPIron($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_supplements` a
    JOIN maternalcare_postpartum b ON b.postpartum_id = a.postpartum_id
    JOIN maternalcare d ON d.maternalcase_id = b.maternalcase_id
    JOIN healthcare_services e ON e.healthcareservice_id = d.healthcareservice_id
    JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
    JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
    JOIN facilities h ON h.facility_id = g.facility_id
    JOIN patients i ON i.patient_id = f.patient_id
    WHERE g.facility_id = '$facility->facility_id'
    AND `supplement_type` = 2
    AND MONTH(a.created_at) = $month
    AND YEAR(a.created_at) = $year
    GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = $val[0]->count;
        }

        return $t;
    }

    public static function scopePP2V($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT g.facility_id, count(*) as 'count' FROM `maternalcare_visits` a
        JOIN maternalcare_postpartum b ON b.postpartum_id = a.postpartum_id
        JOIN maternalcare d ON d.maternalcase_id = b.maternalcase_id
        JOIN healthcare_services e ON e.healthcareservice_id = d.healthcareservice_id
        JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
        JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
        JOIN facilities h ON h.facility_id = g.facility_id
        WHERE a.`postpartum_id` IS NOT NULL
        AND 'count' > 2
        AND MONTH(a.created_at) = $month
        AND YEAR(a.created_at) = $year
        GROUP BY g.facility_id, MONTH(a.`created_at`)";

        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = $val[0]->count;
        }

        return $t;
    }

    public static function scopePreIron($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_supplements` a
    JOIN maternalcare_prenatal b ON b.prenatal_id = a.prenatal_id
    JOIN maternalcare d ON d.maternalcase_id = b.maternalcase_id
    JOIN healthcare_services e ON e.healthcareservice_id = d.healthcareservice_id
    JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
    JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
    JOIN facilities h ON h.facility_id = g.facility_id
    JOIN patients i ON i.patient_id = f.patient_id
    WHERE g.facility_id = '$facility->facility_id'
    AND `supplement_type` = 2
    AND MONTH(a.created_at) = $month
    AND YEAR(a.created_at) = $year
    GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = $val[0]->count;
        }

        return $t;
    }

    public static function scopeTT2($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT (SELECT g.facility_id FROM healthcare_services e
JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id WHERE e.healthcareservice_id = a.healthcareservice_id AND h.facility_id = '$facility->facility_id') as 'facid', a.`subservice_id` FROM `patient_immunization` a
WHERE a.`immun_type` > 1
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY 'facid', a.`subservice_id`";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopeTT2x($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT (SELECT g.facility_id FROM healthcare_services e
JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id WHERE e.healthcareservice_id = a.healthcareservice_id AND h.facility_id = '$facility->facility_id') as 'facid', a.`subservice_id`, count(*) as 'count' FROM `patient_immunization` a
WHERE MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY 'facid', a.`subservice_id`
HAVING 1 < count(*)";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopePre4Visit($month, $year)
    {

        $facility = Session::get('facility_details');

        $sql = "SELECT (SELECT g.facility_id FROM healthcare_services e
JOIN facility_patient_user f ON f.facilitypatientuser_id = e.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id WHERE e.healthcareservice_id = b.healthcareservice_id AND h.facility_id = '$facility->facility_id') as 'facid', c.prenatal_id, count(*) FROM `maternalcare_visits` a
JOIN maternalcare b ON b.maternalcase_id = a.maternalcase_id
JOIN maternalcare_prenatal c ON c.maternalcase_id = b.maternalcase_id
WHERE MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY c.prenatal_id
HAVING 3 < count(*)";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopeCCare($type, $sex, $month, $year)
    {
        switch($type) {
            case 'BCG': $col = 'bcg_actual_date'; break;
            case 'DPT1': $col = 'dpt1_actual_date'; break;
            case 'DPT2': $col = 'dpt2_actual_date'; break;
            case 'DPT3': $col = 'dpt3_actual_date'; break;
            case 'HPB1': $col = 'hepa_b1_actual_date'; break;
            case 'HPB2': $col = 'hepa_b2_actual_date'; break;
            case 'MEAS': $col = 'measles_actual_date'; break;
            case 'OPV1': $col = 'opv1_actual_date'; break;
            case 'OPV2': $col = 'opv2_actual_date'; break;
            case 'OPV3': $col = 'opv3_actual_date'; break;
            case 'PENTA1': $col = 'penta1_actual_date'; break;
            case 'PENTA2': $col = 'penta2_actual_date'; break;
            case 'PENTA3': $col = 'penta3_actual_date'; break;
            case 'ROTA1': $col = 'rota1_actual_date'; break;
            case 'ROTA2': $col = 'rota2_actual_date'; break;
            case 'ROTA3': $col = 'rota3_actual_date'; break;
            case 'PCV1': $col = 'pcv1_actual_date'; break;
            case 'PCV2': $col = 'pcv2_actual_date'; break;
            case 'PCV3': $col = 'pcv3_actual_date'; break;
            case 'MCV1': $col = 'mcv1_actual_date'; break;
            case 'MCV2': $col = 'mcv2_actual_date'; break;
        }
        $facility = Session::get('facility_details');

        $sql = "SELECT g.facility_id, count(*) FROM `pediatrics_service` a
JOIN healthcare_services b ON b.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user f ON f.facilitypatientuser_id = b.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id
JOIN patients i ON i.patient_id = a.patient_id
WHERE a.$col IS NOT NULL
AND a.`patient_id` != ''
AND i.gender = '$sex'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND h.facility_id = '$facility->facility_id'
GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopeFullImmune($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT TIMESTAMPDIFF(YEAR,i.birthdate,a.created_at) as 'age', g.facility_id, count(*) FROM `pediatrics_service` a
JOIN healthcare_services b ON b.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user f ON f.facilitypatientuser_id = b.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id
JOIN patients i ON i.patient_id = a.patient_id
WHERE a.bcg_actual_date IS NOT NULL
AND a.opv1_actual_date IS NOT NULL
AND a.opv2_actual_date IS NOT NULL
AND a.opv3_actual_date IS NOT NULL
AND a.pcv1_actual_date IS NOT NULL
AND a.pcv2_actual_date IS NOT NULL
AND a.pcv3_actual_date IS NOT NULL
AND a.measles_actual_date IS NOT NULL
AND a.`patient_id` != ''
AND 'age' < 1
AND i.gender = '$sex'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND h.facility_id = '$facility->facility_id'
GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopeCompleteImmune($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT TIMESTAMPDIFF(YEAR,i.birthdate,a.created_at) as 'age', g.facility_id, count(*) FROM `pediatrics_service` a
JOIN healthcare_services b ON b.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user f ON f.facilitypatientuser_id = b.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = f.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id
JOIN patients i ON i.patient_id = a.patient_id
WHERE a.bcg_actual_date IS NOT NULL
AND a.opv1_actual_date IS NOT NULL
AND a.opv2_actual_date IS NOT NULL
AND a.opv3_actual_date IS NOT NULL
AND a.pcv1_actual_date IS NOT NULL
AND a.pcv2_actual_date IS NOT NULL
AND a.pcv3_actual_date IS NOT NULL
AND a.measles_actual_date IS NOT NULL
AND a.`patient_id` != ''
AND 'age' > 1
AND 'age' < 2
AND i.gender = '$sex'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND h.facility_id = '$facility->facility_id'
GROUP BY g.facility_id";
        $val = DB::select( DB::raw( $sql ));
        $t = 0;
        if($val) {
            $t = count($val);
        }

        return $t;
    }

    public static function scopeLiveBirth($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) as 'count' FROM `maternalcare_delivery` a
JOIN maternalcare b ON b.`maternalcase_id` = a.`maternalcase_id`
JOIN healthcare_services c ON c.healthcareservice_id = b.healthcareservice_id
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN patients g ON g.patient_id = d.patient_id
WHERE e.facility_id = '$facility->facility_id'
AND a.`termination_outcome` = 'LB'
AND g.gender = '$sex'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeChildProtect($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) FROM `maternalcare_delivery` a
JOIN `patient_immunization` b ON b.subservice_id = a.`maternalcase_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = b.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN patients g ON g.patient_id = d.patient_id
WHERE e.facility_id = '$facility->facility_id'
AND a.`termination_outcome` = 'LB'
AND b.immunization_code = 'tetanus'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND g.gender = '$sex'
GROUP BY a.`maternalcase_id`
HAVING 2 < count(*)";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeSixMonthSeen($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*) FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE TIMESTAMPDIFF(MONTH, b.birthdate, a.updated_at) = 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeBreastFeed($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`is_breastfed_first_month` = 1
AND a.`is_breastfed_second_month` = 1
AND a.`is_breastfed_third_month` = 1
AND a.`is_breastfed_fourth_month` = 1
AND a.`is_breastfed_fifth_month` = 1
AND a.`is_breastfed_sixth_month` = 1
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.updated_at) <= 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeCompFood($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`complimentary_food_sixth` IS NOT NULL
AND a.`complimentary_food_seventh` IS NOT NULL
AND a.`complimentary_food_eight` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`complimentary_food_eight`) <= 8
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`complimentary_food_eight`) >= 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeNBornRef($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`newborn_screening_referral_date` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`newborn_screening_referral_date`) < 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeNBornDone($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`newborn_screening_actual_date` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`newborn_screening_actual_date`) < 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeVitAFirst($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`vit_a_supp_first_date` IS NOT NULL
AND a.`vit_a_first_age` <= 11
AND a.`vit_a_first_age` >= 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeVitASecond($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`vit_a_supp_first_date` IS NOT NULL
AND a.`vit_a_supp_second_date` IS NOT NULL
AND a.`vit_a_second_age` <= 59
AND a.`vit_a_second_age` >= 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeIronA($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`iron_supp_start_date` IS NOT NULL
AND a.`vit_a_first_age` <= 11
AND a.`vit_a_first_age` >= 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeIronB($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`iron_supp_start_date` IS NOT NULL
AND a.`vit_a_second_age` <= 59
AND a.`vit_a_second_age` >= 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeMNPA($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`mnp_6_11` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`mnp_6_11`) <= 11
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`mnp_6_11`) >= 6
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeMNPB($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `pediatrics_service` a
JOIN `patients` b ON b.`patient_id` = a.`patient_id`
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
WHERE a.`mnp_12_23` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`mnp_12_23`) <= 23
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`mnp_12_23`) >= 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeDeWorm($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `medicalorder` c ON c.healthcareservice_id = a.healthcareservice_id
JOIN `medicalorder_prescription` g ON g.medicalorder_id = c.medicalorder_id
WHERE c.medicalorder_type = 'MO_MED_PRESCRIPTION'
AND (g.generic_name LIKE '%Pyrantel%'
OR g.generic_name LIKE '%Praziquantel%'
OR g.generic_name LIKE '%Albendazole%')
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`created_at`) <= 59
AND TIMESTAMPDIFF(MONTH, b.birthdate, a.`created_at`) >= 12
AND e.facility_id = '$facility->facility_id'
AND MONTH(a.created_at) = $month
AND YEAR(a.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeSickSeen($aa, $ab, $sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN `vital_physical` h ON h.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `diagnosis` c ON c.healthcareservice_id = a.healthcareservice_id
WHERE (c.diagnosislist_id LIKE '%Severe Pneumonia%'
OR c.diagnosislist_id LIKE '%Persistent Diarrhea%'
OR c.diagnosislist_id LIKE '%Measles%'
OR h.weight <= 2.5)
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= $ab
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= $aa
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeSickVitA($aa, $ab, $sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN `vital_physical` h ON h.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `diagnosis` c ON c.healthcareservice_id = a.healthcareservice_id
JOIN `pediatrics_service` g ON a.healthcareservice_id = g.healthcareservice_id
WHERE (c.diagnosislist_id LIKE '%Severe Pneumonia%'
OR c.diagnosislist_id LIKE '%Persistent Diarrhea%'
OR c.diagnosislist_id LIKE '%Measles%'
OR h.weight <= 2.5)
AND g.`vit_a_supp_first_date` IS NOT NULL
AND g.`vit_a_supp_second_date` IS NOT NULL
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= $ab
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= $aa
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeLowWt($aa, $ab, $sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT e.facility_id, count(*)
FROM vital_physical a
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
WHERE a.weight <= 2.5
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= $ab
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= $aa
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeLowWtIron($aa, $ab, $sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT e.facility_id, count(*)
FROM vital_physical a
JOIN `healthcare_services` c ON c.`healthcareservice_id` = a.`healthcareservice_id`
LEFT JOIN `pediatrics_service` g ON g.`healthcareservice_id` = a.`healthcareservice_id`
JOIN facility_patient_user d ON d.facilitypatientuser_id = c.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
WHERE a.weight <= 2.5
AND MONTH(g.iron_supp_start_date) = MONTH(c.`created_at`)
AND YEAR(g.iron_supp_start_date) = YEAR(c.`created_at`)
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= $ab
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= $aa
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeDiarrhea($aa, $ab, $sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `diagnosis` c ON c.healthcareservice_id = a.healthcareservice_id
WHERE c.diagnosislist_id LIKE '%Diarrhea%'
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= $ab
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= $aa
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }


    public static function scopePneumonia($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `diagnosis` c ON c.healthcareservice_id = a.healthcareservice_id
WHERE c.diagnosislist_id LIKE '%Pneumonia%'
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= 59
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= 0
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopePneumoniaTreat($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `diagnosis` c ON c.healthcareservice_id = a.healthcareservice_id
JOIN `medicalorder` g ON g.healthcareservice_id = a.healthcareservice_id
JOIN `medicalorder_prescription` h ON h.medicalorder_id = g.medicalorder_id
WHERE g.medicalorder_type = 'MO_MED_PRESCRIPTION'
AND c.diagnosislist_id LIKE '%Pneumonia%'
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) <= 59
AND TIMESTAMPDIFF(MONTH, b.birthdate, c.`created_at`) >= 0
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeTBDSSM($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `tuberculosis_record` c ON c.healthcareservice_id = a.healthcareservice_id
JOIN `tuberculosis_dssm_record` g ON g.tb_record_number = c.tb_record_number
WHERE g.result IS NOT NULL
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

    public static function scopeTBDSSMPos($sex, $month, $year)
    {
        $facility = Session::get('facility_details');

        $sql = "SELECT count(*)
FROM `healthcare_services` a
JOIN facility_patient_user d ON d.facilitypatientuser_id = a.facilitypatientuser_id
JOIN facility_user e ON e.facilityuser_id = d.facilityuser_id
JOIN facilities f ON f.facility_id = e.facility_id
JOIN `patients` b ON b.`patient_id` = d.`patient_id`
JOIN `tuberculosis_record` c ON c.healthcareservice_id = a.healthcareservice_id
JOIN `tuberculosis_dssm_record` g ON g.tb_record_number = c.tb_record_number
WHERE g.result LIKE '%positive%'
AND g.category_of_treatment IS NOT NULL
AND e.facility_id = '$facility->facility_id'
AND MONTH(c.created_at) = $month
AND YEAR(c.created_at) = $year
AND b.gender = '$sex'
GROUP BY e.facility_id";

        $val = DB::select( DB::raw( $sql ));

        if($val) {
            return $val[0]->count;
        } else {
            return 0;
        }
    }

}
