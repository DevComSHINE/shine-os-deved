<?php namespace ShineOS\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Reminders\Http\Requests\ReminderFormRequest;
use ShineOS\Core\Reminders\Http\Requests\BroadcastFormRequest;

use ShineOS\Core\Reminders\Entities\Reminders;
use ShineOS\Core\Reminders\Entities\ReminderMessage;
use Shine\Libraries\EmailHelper;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\UserHelper;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\ChikkaSMS;
use Shine\Libraries\Utils;

use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityUser as facilityUser;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser as facilityPatientUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientContacts;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Users\Entities\UserContact;

use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

/**
 * Cron Controller
 */
class CronController extends Controller {

    public function __construct() {

        /**
         * User Session or Authenticaion
         */
        $this->curr_time = new DateTime('NOW');

        /**
         * Reminder Types, as Email's subject
         * @var array
         */
        $this->subject = [
            "1" => "Prescription Schedule",
            "2" => "Follow-up Consultation Appointment",
            "3" => "Lab Exam Results"
        ];
        $this->rtype = [
            "1" => "PRESC",
            "2" => "FOLLO",
            "3" => "EXAMR"
        ];

        $modules =  Utils::getModules();

    }

    /**
     * Cron
     * @return array
     */
    public function index() {

    }

    /**
     * Facility Session
     * @return array
     */
    public function facility() {
        return FacilityHelper::facilityInfo();
    }
    /**
     * User's session
     * @return array
     */
    public function currUser(){
        return UserHelper::getUserInfo();
    }

    /**
     * Sending Email
     * @param  String $recipientName               Recipient Name
     * @param  String $recipientEmail              Recipient Email
     * @param  String $subject                     Subject of email
     * @param  String $message                     Email message
     * @param  Datetime [$appointment_datetime=NULL] Date & time specified for the message
     * @return Result of sendmail
     */
    public function sendToEmail($recipientName, $recipientEmail, $subject, $message, $appointment_datetime=NULL) {
        $FromUser = $this->currUser();
        $FromFacility = $this->facility();
        $data = array(
                'toUser_name' => $recipientName,
                'toUser_email' => $recipientEmail,
                'subj' => $subject,
                'msg' => $message,
                'appointment_datetime' => $appointment_datetime,
                'fromUser_name' => $FromUser->first_name.' '.$FromUser->middle_name.' '.$FromUser->last_name,
                'fromFacility' => $FromFacility->facility_name
                );
        $response = EmailHelper::SendReminderMessage($data);
        return $response;
    }

    /**
    *
    */
    public function updateStatus($remindermessage_id, $updateArr) {
        $stats = ReminderMessage::where('remindermessage_id', $remindermessage_id)->update($updateArr);
        return $stats;
    }


    function cronReminders()
    {
        //let us collect all reminders for sending today
        $today = date('Y-m-d');

        $reminders = ReminderMessage:: whereRaw('DATE_FORMAT(`reminder_message`.`appointment_datetime` - INTERVAL `reminder_message`.`daysbeforesending` DAY, "%Y-%m-%d") = "'.$today.'"')
                    ->where('reminder_message.sent_status', '<>', 'SENT')
                    ->join('reminders', 'reminders.remindermessage_id','=','reminder_message.remindermessage_id')
                    ->join('patients', 'patients.patient_id','=','reminders.patient_id')
                    ->select('reminders.*', 'reminder_message.*', 'patients.first_name', 'patients.middle_name', 'patients.last_name')
                    ->get();

        foreach($reminders as $reminder) {
            /** Email Sending */
            if($reminder->remindermessage_type == 'FOLLO') {

                $emailmessage = "Dear ".$reminder->first_name.",<br><br>Your next follow-up appointment is on ".date('M d, Y h:i:s A', strtotime($reminder->appointment_datetime)).". Your doctor also sends the following message:<br><br>".$reminder->reminder_message."<br><br>This is a system notification. Do not reply.";

                $smsmessage = "SHINEOS+ SMS Appointment Reminder: Your next follow-up appointment is on ".date('M d, Y h:i:s A', strtotime($reminder->appointment_datetime)).".";
            } else {
                $emailmessage = "Dear ".$reminder->first_name.",<br><br>You are being notified by your Health provider with the following message:<br><br>".$reminder->reminder_message."<br><br>This is a system notification. Do not reply.";
                $smsmessage = "SHINEOS+ SMS Reminder: ".$reminder->reminder_message;
            }

            $patient = getCompletePatientByPatientID($reminder->patient_id);
            $patientName =  $reminder->first_name.' '.$reminder->middle_name.' '.$reminder->last_name;
            if($patient->patientContact->email) {
                $sendEmail = $this->sendToEmail($patientName, $patient->patientContact->email, $reminder->reminder_subject, $emailmessage, $reminder->appointment_datetime);
            }

            /** INSERT SMS CHIKKA */
            if($patient->patientContact->mobile) {
                $mob = '63'.substr( str_replace("-", "", $patient->patientContact->mobile), 1);
                 $ChikkaSMS = new ChikkaSMS;
                 $sendText = $ChikkaSMS->sendText($reminder->remindermessage_id, $mob, $smsmessage);
            }

            //update the status to SENT
            ReminderMessage::where('reminder_message.remindermessage_id',$reminder->remindermessage_id)->update(['reminder_message.sent_status'=>'SENT']);
        }
    }


    public function testemail()
    {
        $data = array(
                'toUser_name' => "Romel John Santos",
                'toUser_email' => "rjsantos@ateneo.edu",
                'subj' => "Broadcast: Subject",
                'msg' => "<p>Quisque elit urna, rhoncus at nunc in, aliquam bibendum nunc. Proin ipsum ex, gravida hendrerit iaculis eget, malesuada at nunc! In pretium risus eu enim finibus auctor? Mauris eget nunc placerat, efficitur mi condimentum, fringilla enim? Aliquam erat volutpat. Cras tempus odio eu velit fermentum, et tempor justo vehicula. In non lectus et sem ultricies commodo? Etiam id egestas diam. Nam vel metus leo.</p>
                <p>Phasellus egestas elementum sollicitudin. Vivamus at rutrum leo, nec ornare urna. Curabitur viverra augue et eros gravida, non hendrerit quam vehicula. Quisque id malesuada lacus. Integer sed cursus tortor. Phasellus finibus efficitur mollis. Vestibulum accumsan tellus arcu, quis congue odio pretium ut. Proin molestie fermentum ex! Duis at ipsum id leo imperdiet scelerisque. Aenean mollis interdum eleifend. Nam id enim lacinia, feugiat urna vitae, luctus dui! Pellentesque vehicula diam sed placerat dapibus.</p>",
                'appointment_datetime' => "2016-05-09",
                'fromUser_name' => "SHINE OS+ Administrator",
                'fromFacility' => "SHINE OS+ Test Clinic"
                );
        EmailHelper::SendReminderMessage($data);
        return view('reminders::emails.remind', $data);
    }
}
