<?php

use ShineOS\Core\Reminders\Entities\Reminders;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityUser as facilityUser;

use Shine\Libraries\FacilityHelper;

function countRemindersByFacilityID($id)
{
    $all_facilityUser = facilityUser::where('facility_id',$id)->lists('facilityuser_id');

    $reminders = Reminders::whereIn('reminder_message.reminder_type', array(1,2,3))
                    ->whereIn('facilityuser_id', $all_facilityUser)
                    ->join('reminder_message', 'reminders.remindermessage_id','=','reminder_message.remindermessage_id')
                    ->join('patients', 'patients.patient_id','=','reminders.patient_id')
                    ->get();

    return count($reminders);
}


function getAppointments($start, $end = NULL)
{
    $facilityInfo = FacilityHelper::facilityInfo();

    if($end == NULL) {
        //visits today
        $rawsql = 'DATE_FORMAT(`visit_date`, "%Y-%m-%d") = "'.date('Y-m-d').'"';
    } else {
        //visits from date range
        $rawsql = 'DATE_FORMAT(`visit_date`, "%Y-%m-%d") BETWEEN "'.$start.'" AND "'.$end.'"';
    }

    //get only appointments that were SENT by SMS/Email
    $appointments = DB::table('visits_view')
        ->where('facility_id', $facilityInfo->facility_id)
        ->whereNull('deleted')
        ->whereRaw($rawsql)
        ->orderBy('visit_date', 'DESC')
        ->get();

    foreach ($appointments as $k => $v) {
        $v->seen_by = findUserByFacilityUserID($v->seen_by);
    }

    return $appointments;
}
