<?php namespace ShineOS\Core\Reminders\Http\Controllers;

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
 * Reminder's and Broadcast's Controller
 */
class RemindersController extends Controller {

    /**
     * Reminders table
     * @var string
     */
    protected $table_name = 'reminders';
    protected $moduleName = 'Reminders';
    protected $modulePath = 'reminders';

    public function __construct() {
        /**
         * User Session or Authenticaion
         */
        $this->middleware('auth');
        $this->curr_time = new DateTime('NOW');

        /**
         * Reminder Types, as Email's subject
         * @var array
         */
        $this->subject = [
            false => "Reminders",
            "1" => "Prescription Schedule",
            "2" => "Follow-up Consultation Appointment",
            "3" => "Lab Exam Results"
        ];
        $this->rtype = [
            "1" => "PRESC",
            "2" => "FOLLO",
            "3" => "EXAMR"
        ];

        /**
         * Current Facility Id
         * @var string
         */
        $this->c_facility_id = isset($this->facility()->facility_id) ? $this->facility()->facility_id : false;

        $modules =  Utils::getModules();

        // variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

    }

    /**
     * Reminder's Listings
     * @return array
     */
    public function index() {
        $data = $this->listings(array(1,2,3), $this->c_facility_id);
        return view('reminders::index')->with($data);
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
     * Broadcast's Listings
     * @return array
     */
    public function broadcastlist() {
        $data = $this->listings(array(4), $this->c_facility_id);
        return view('reminders::broadcast')->with($data);
    }

    /**
     * Listings for Reminders and Broadcasts
     * @param  array $arrType Reminder Type
     * @return array
     */
    public function listings($arrType, $c_facility_id) {
        /**
         * get all facilityuserid  to get all patient's data connected to the current Facility
         * @var array
         */
        $all_facilityUser = facilityUser::where('facility_id',$c_facility_id)->lists('facilityuser_id');

        /** For Broadcasts Listings */
        if(in_array('4', $arrType)) {
            $data['join'] = Reminders:: whereIn('reminder_message.reminder_type', $arrType)
                    ->whereIn('facilityuser_id', $all_facilityUser)
                    ->join('reminder_message', 'reminders.remindermessage_id','=','reminder_message.remindermessage_id')
                    ->groupBy('reminders.remindermessage_id')
                    ->orderBy('reminder_message.updated_at', 'desc')
                    ->paginate(10);
        }
        /**  Fro Reminders Listings */
        else {
            $data['join'] = Reminders:: whereIn('reminder_message.reminder_type', $arrType)
                    ->whereIn('facilityuser_id', $all_facilityUser)
                    ->join('reminder_message', 'reminders.remindermessage_id','=','reminder_message.remindermessage_id')
                    ->join('patients', 'patients.patient_id','=','reminders.patient_id')
                    ->select('reminders.*', 'reminder_message.*', 'patients.first_name', 'patients.middle_name', 'patients.last_name')
                    ->orderBy('reminder_message.updated_at', 'desc')
                    ->paginate(10);
        }
        return $data;
    }

    /**
     * View:: Create a Patient's Reminder
     * @param  string $patient_id
     * @return array
     */
    public function createReminder($patient_id, $healthcareservice_id) {
        $data['healthcareservice_id'] = $healthcareservice_id;
        $data['Patients'] = Patients::with('patientContact')->where('patient_id', $patient_id)->first();
        // echo "<pre>"; print_r($data['Patients']); echo "</pre>";
        if($data['Patients']->patientContact['mobile'] != NULL || $data['Patients']->patientContact['email'] != NULL) {
            return view('reminders::createreminder')->with($data);
        } else {
            return Redirect::to('healthcareservices/edit/'.$patient_id.'/'.$healthcareservice_id)
                         ->with('flash_message', 'Error: No contacts found for your patient, unable to create a reminder.')
                         ->with('flash_type', 'alert-danger alert-dismissible');
        }
    }

    /**
     * Insert patient's reminder
     * @param  ReminderFormRequest $request form validation
     * @return flash message
     */
    public function insertReminder() {
        $newId = IdGenerator::generateId();
        $userId = $this->currUser()->user_id;
        $facilityId = $this->facility()->facility_id;
        $facilityUserId = facilityUser::where(array('user_id'=>$userId,'facility_id'=>$facilityId))->pluck('facilityuser_id');

        /** Reminders */
        $patientId = Input::has('patientId') ? Input::get('patientId')  : false;
        $type = Input::has('reminder_type') ? Input::get('reminder_type')  : false;
        $healthcareservice_id = Input::has('healthcareservice_id') ? Input::get('healthcareservice_id')  : false;

        /** Reminder Messages */
        $datetime = new DateTime(Input::get('date') . ' ' . Input::get('time'));
        $datetime = $datetime->format('Y-m-d H:i:s');
        $send_days = Input::get('send_days');
        $mobile = Input::get('reminder_mobile');
        $email = Input::has('reminder_email') ? Input::get('reminder_email')  : false;
        $message = Input::has('message') ? Input::get('message')  : false;

        $ReminderMessage = new ReminderMessage;
        $ReminderMessage->remindermessage_id = $newId;
        $ReminderMessage->reminder_message = $message;
        $ReminderMessage->daysbeforesending = $send_days;
        $ReminderMessage->reminder_subject = $this->subject[$type];
        $ReminderMessage->appointment_datetime = $datetime;
        $ReminderMessage->status = '1';
        $ReminderMessage->sent_status = 'SET';
        $ReminderMessage->reminder_type = $type;
        $ReminderMessage->remindermessage_type = $this->rtype[$type];
        $remindermessage_id = $ReminderMessage->remindermessage_id;
        $ReminderMessagesave = $ReminderMessage->save();

        $Reminders = new Reminders();
        $Reminders->reminder_id = $newId;
        $Reminders->healthcareservice_id = $healthcareservice_id;
        $Reminders->facilityuser_id = $facilityUserId;
        $Reminders->patient_id = $patientId;
        $Reminders->user_id = '';

        $Reminders->remindermessage_id = $remindermessage_id;
        $Reminderssave = $Reminders->save();


        if($ReminderMessagesave && $Reminderssave) {
            $flash_type = 'alert-success';
            $flash_message = 'Well done! You successfully added new reminder.';
        } else {
            $flash_type = 'alert-danger';
            $flash_message = 'Failed to add';
        }

        return redirect('reminders')
                ->with('flash_message', $flash_message)
                ->with('flash_type', $flash_type);
    }

    /**
     * View:: Create a Broadcast to either User or Patient
     */
    public function createBroadcast() {
        return view('reminders::createbroadcast');
    }

    /**
     * Insert a broadcast
     * @param  BroadcastFormRequest $request form validation
     * @return flash message
     */
    public function insertBroadcast() {
        $newId = IdGenerator::generateId();
        $userId = $this->currUser()->user_id;
        $facilityId = $this->facility()->facility_id;
        $facilityUserId = facilityUser::where(array('user_id'=>$userId,'facility_id'=>$facilityId))->pluck('facilityuser_id');

        $reminder_type = Input::get('reminder-reminder_type');
        $message = Input::get('message');
        $subject = Input::get('subject');
        $smsmessage = "You received a broadcast message from SHINE OS+: ".$subject.". Check your SHINE OS+ account now.";

        if($reminder_type == 'BROADCAST_PATIENTS') {
            $List = facilityPatientUser::where('facilityuser_id',$facilityUserId)->select('patient_id as id')->get();
        } else {
            $List = facilityUser::where('facility_id', $facilityId)->select('user_id as id')->get();
        }

        if($List->count() > 0) {
            $ReminderMessage = new ReminderMessage;
            $ReminderMessage->remindermessage_id = $newId;
            $ReminderMessage->reminder_message = $message;
            $ReminderMessage->reminder_subject = "SHINE OS+ Broadcast: ".$subject;
            $ReminderMessage->reminder_type = '4'; //broadcast
            $ReminderMessage->remindermessage_type = $reminder_type;
            $ReminderMessage->status = 1;
            $ReminderMessage->sent_status = 'SENT';

            $remindermessage_id = $ReminderMessage->remindermessage_id;
            $Reminderssave = $ReminderMessage->save();
            // echo "<pre>"; print_r($ReminderMessage); echo "</pre>";

            foreach ($List as $key => $value) {
                $Reminders = new Reminders();
                $Reminders->reminder_id = $newId.$key;
                $Reminders->facilityuser_id = $facilityUserId;

                /** Broadcast to Patients or to User */
                if($reminder_type == 'BROADCAST_PATIENTS') {
                    /** Patients List
                     * Insert to Patient Id field */
                    $Reminders->patient_id = $value['id'];
                    $Reminders->user_id = '';
                    $emailDetails = Patients::where('patients.patient_id',$value['id'])
                                            ->leftjoin('patient_contact', 'patients.patient_id','=','patient_contact.patient_id')
                                            ->select('patients.first_name', 'patients.last_name', 'patient_contact.email', 'patient_contact.mobile')
                                            ->first();
                    $numberDetails = $emailDetails->mobile;
                } else {
                    /** Users List
                     * Insert to User Id field */
                    $Reminders->patient_id = '';
                    $Reminders->user_id = $value['id'];
                    $emailDetails = Users::where('user_id',$value['id'])->first();
                    $num = UserContact::where('user_id',$value['id'])->first();
                    $numberDetails = $num->mobile;
                }


                $Reminders->remindermessage_id = $remindermessage_id;
                $ReminderMessagesave = $Reminders->save();

                /** Patients or Users with Email */
                if($ReminderMessagesave && $Reminderssave) {
                    $sendEmail = NULL;
                    $sendText = NULL;

                    $fullName = $emailDetails->first_name.' '.$emailDetails->middle_name.' '.$emailDetails->last_name;
                    if($numberDetails!=NULL OR $numberDetails!="" OR $numberDetails!="N/A") {
                        $mob = '63'.substr( str_replace("-", "", $numberDetails), 1);
                         $ChikkaSMS = new ChikkaSMS;
                         $sendText = $ChikkaSMS->sendText($newId, $mob, $smsmessage);
                    }
                    if($emailDetails->email) {
                        $sendEmail = $this->sendToEmail($fullName, $emailDetails->email, $subject, $message, NULL);
                    }

                    if($sendEmail || $sendText) {
                        $updateArr = ['sent_status'=>'SENT'];
                        $this->updateStatus($remindermessage_id, $updateArr);
                    }
                }
            }

            if($ReminderMessagesave && $Reminderssave) {
                $flash_type = 'alert-success';
                $flash_message = 'Well done! You successfully added new broadcast.';
            } else {
                $flash_type = 'alert-danger';
                $flash_message = 'Failed to add';
            }
        } else {
            $flash_type = 'alert-danger';
            $flash_message = 'Failed to add. No record found.';
        }

        return redirect('broadcast')
                    ->with('flash_message', $flash_message)
                    ->with('flash_type', $flash_type);
    }

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

    /**
    *
    */
    public function deleteReminderBroadcast($reminder_id) {
        // dd($reminder_id);
        $query = Reminders::where('reminder_id', $reminder_id)
                            ->delete();

        if($query) {
            return Redirect::back()
                         ->with('flash_message', 'Successfully deleted')
                         ->with('flash_type', 'alert-success');
        } else {
            return Redirect::back()
                         ->with('flash_message', 'Error: Failed to delete.')
                         ->with('flash_type', 'alert-danger');
        }
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
