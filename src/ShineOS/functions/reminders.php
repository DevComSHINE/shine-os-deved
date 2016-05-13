<?php

use ShineOS\Core\Reminders\Entities\Reminders;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityUser as facilityUser;

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
