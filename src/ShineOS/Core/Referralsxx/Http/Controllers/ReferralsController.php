<?php
namespace ShineOS\Core\Referrals\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Referrals\Entities\Referrals;
use ShineOS\Core\Referrals\Entities\ReferralReasons as referralReasons;
use ShineOS\Core\Referrals\Entities\Referralmessages as referralmessages;
use ShineOS\Core\Referrals\Http\Requests\ReferralsFormRequest;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Facilities\Entities\FacilityUser as facilityUser;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser as facilityPatientUser;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\healthcareservicetype;
use ShineOS\Core\Roles\Entities\Features as Features;
use ShineOS\Core\LOV\Entities\LovReferralReasons;
use Shine\Libraries\Utils;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\UserHelper;
use Shine\Libraries\EmailHelper;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;

use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

/** Referrals Controller */
class ReferralsController extends Controller {
    protected $moduleName = 'Referrals';
    protected $modulePath = 'referrals';

    private $healthcareRepository;

    public function __construct(HealthcareRepository $healthcareRepository) {
        $this->HealthcareRepository = $healthcareRepository;
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $this->referralReasons = LovReferralReasons::lists('referral_reason','lovreferralreason_id');
        $modules =  Utils::getModules();
        $this->ref_facility_id = $this->facilitySession();
        // variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

    }

    /**
     * @return array() facility session includes all details of the facility from the database
     */
    public function facilitySession() {
        return FacilityHelper::facilityInfo();
    }

    /**
     * @return array() user session includes all details of the user from the database
     */
    public function userSession() {
        return UserHelper::getUserInfo();
    }


    /**
     * Referrals: Inbound Listing
     * @return array */
    public function index() {
        $data['facilityid'] = $current_facilityid = $this->facilitySession()->facility_id; //session
        $referrals = $this->getReferral(array(1, 2, 3, 4), $current_facilityid, 'inbound');
            foreach ($referrals as $key => $value) {
                $data['referrals'] = $value;
            }
        // echo "<pre>"; print_r($data['referrals']); echo "</pre>";
        return view('referrals::index')->with($data);
    }

    /**
     * Referrals: Outbound and Drafts Listing
     * @return array */
    public function outboundDraft() {
        $data['facilityid'] = $current_facilityid = $this->facilitySession()->facility_id;
        $getallhealthcareid = $this->getFacilityUser($current_facilityid);
        // dd($getallhealthcareid);
        if(Request::path() == 'referrals/outbound') {
            $referrals = $this->getReferral(array(1, 2, 3, 4), $getallhealthcareid, 'outbound');
            if($referrals) {
                foreach ($referrals as $key => $value) {
                $data['referrals'] = $value;
                }
            }
        }
        if(Request::path() == 'referrals/drafts') {
            $referrals = $this->getReferral(array(6), $getallhealthcareid, 'drafts');
            if($referrals) {
                foreach ($referrals as $key => $value) {
                $data['referrals'] = $value;
                }
            }
        }
        return view('referrals::index')->with($data);
    }

    public function getFacilityUser($facility_id) {
        /*
        Changed by RJBS to include all records
        // get facility user of current facility id
        $all_facilityUser = facilityUser::where('facility_id',$facility_id)->lists('facilityuser_id');
        $getfacilitypatientuser = facilityPatientUser::whereIn('facilityuser_id', $all_facilityUser)->get(); //lists('facilitypatientuser_id');
        $getallhealthcareid = collect();
        foreach($getfacilitypatientuser as $fpu) {
            $h = Healthcareservices::where('facilitypatientuser_id', $fpu->facilitypatientuser_id)->lists('healthcareservice_id');
            $getallhealthcareid = $getallhealthcareid->merge($h);
            $getallhealthcareid->all();
        }
        $checkReferral = Referrals::whereIn('healthcareservice_id', $getallhealthcareid)->lists('referral_id');*/

        $hcs = getAllHealthcareByFacilityID($facility_id);
        $getallhealthcareid = array();
        foreach($hcs as $h){
            array_push($getallhealthcareid, $h->healthcareservice_id);
        }
        //dd($getallhealthcareid);
        return $getallhealthcareid;
    }

    /**
     * Referrals: Listings
     * @param  string $arrayId referral_status
     * @param  string $Id      facility_id
     * @param  string $type    inbound, outbound or drafts
     * @return array  $data
     */
    public function getReferral($arrayId, $Id, $type) {
        $data = array();
        if($type == 'inbound') {
            $data['referrals'] = Referrals::whereIn('referral_status', $arrayId)->where('facility_id', $Id)->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $data['referrals'] = Referrals::whereIn('referral_status', $arrayId)->whereIn('healthcareservice_id', $Id)->orderBy('created_at', 'DESC')->paginate(10);
        }

        if($data['referrals']) {
            $this->dataReferral($type, $data['referrals']);
        }

        // echo "<pre>"; print_r($data); echo "</pre>";
        return $data;
    }

    /**
     * Referrals: View referral details
     * @param  string   $type       inbound, outbound or drafts
     * @param  satring  $tableId    referral_id
     * @return array
     */
    public function viewreferral($type, $tableId) {
        $data = array();
        $data['facilityid'] = $this->facilitySession()->facility_id;
        $newDate = new DateTime;

        $data['referrals'] = Referrals::where('referral_id',$tableId)->get();
        if($data['referrals']) {
            $this->dataReferral($type, $data['referrals'], $tableId);
        }

        return view('referrals::viewreferral')->with($data);
    }

    /**
     * Referrals connected data
     * @param  string   $type       inbound, outbound or drafts
     * @param  array    $data       referrals data
     * @param  string   $referralId
     * @return array
     */
    public function dataReferral($type, $data, $referralId=null) {
        foreach($data as $referrals) {
            $DataFromHealthCare = $this->DataFromHealthCare($referrals->healthcareservice_id);
            $healthcareservices = json_decode($this->HealthcareRepository->allFormsByHealthcareserviceid($referrals->healthcareservice_id));
            // $healthcareservices = getAllHealthcareByFacilityID($referrals->healthcareservice_id); 
            foreach ($healthcareservices as $key => $value) {
                $referrals->complaintsData = $value->general_consultation;
                $referrals->diagnosisData = $value->diagnosis;
            }

            $referrals->healthcare_servicetype_name = $DataFromHealthCare['healthcare_servicetype_name'];
            $referrals->referredTo = Facilities::where('facility_id', $referrals->facility_id)->first();
            $referrals->referrer = $DataFromHealthCare['Facilities'];
            $referrals->patient_firstname = $DataFromHealthCare['Patients']->first_name;
            $referrals->patient_middlename = $DataFromHealthCare['Patients']->middle_name;
            $referrals->patient_lastname = $DataFromHealthCare['Patients']->last_name;

            $referrals->type = $type;
            $referrals->reasons = referralReasons::where('referral_id',$referralId)->select('lovreferralreason_id')->get();
            foreach ($referrals->reasons as $key => $value) {
                $refreasonid = $value['lovreferralreason_id'];
                $value->reasondesc = $this->referralReasons[$refreasonid];
            }
        }
        // dd($data);
        return $data;
    }

    /**
     * Referral Messages: follow up message listing
     * @param  string $id
     * @return array
     */
    public function messages($id = null) {
        $data = $this->referralM($id, $this->facilitySession()->facility_id);
        $data['facilityid'] = $this->facilitySession()->facility_id;
        return view('referrals::messages')->with($data);
    }

    /**
     * Referral Messages: View selected message
     * @param  string $id referral Id
     * @return array
     */
    public function viewmessage($id) {
        $data = $this->referralM($id, $this->facilitySession()->facility_id);
        $data['facilityid'] = $this->facilitySession()->facility_id;
        return view('referrals::viewmessage')->with($data);
    }

    /**
     * Referral Messages: Listing and view selected message
     * @param  string $id referral Id
     * @return array
     */
    public function referralM($id=null, $ref_facility_id) {
        $data = array();
        $DataFromFacility = $this->DataFromFacility($ref_facility_id);

        /** Filtering */
        if($id == NULL) {
            $allreferrals = Referrals::WhereIn('healthcareservice_id',$DataFromFacility['healthcareservices'])->orWhere('facility_id',$ref_facility_id)->lists('referral_id');
        } else {
            $allreferrals = Referrals::where('referral_id', $id)->lists('referral_id');
        }

        $refMessages = referralmessages::whereIn('referral_id',$allreferrals)->orderBy('updated_at', 'DESC')->groupBy('referral_id')->lists('referral_id');

        if($refMessages){
            $data['referrals'] = Referrals::whereIn('referral_id',$refMessages)->orderBy('updated_at', 'DESC')->paginate(10);
            foreach ($data['referrals'] as $key => $value) {
                $DataFromHealthCare = $this->DataFromHealthCare($value->healthcareservice_id);
                $value->patientsdata = $DataFromHealthCare['Patients'];
                $value->referrerFacility = $DataFromHealthCare['Facilities'];
                $value->referredFacility = Facilities::where('facility_id', $value->facility_id)->first();
                $value->referrerUser = $DataFromHealthCare['Users'];
                $value->referredUser = Facilities::where('facility_id', $value->facility_id)->first();
                $value->healthcare_servicetype_name = $DataFromHealthCare['healthcare_servicetype_name'];
                $value->referralMessages = referralmessages::where('referral_id',$value->referral_id)->get();
            }
        }
        return $data;
    }
    /**
     * Data from healthcare service
     * @param string $HCS_id healthcare service id
     * @return  array
     */
    public function DataFromHealthCare($HCS_id) {
        $data['healthcareservices'] = Healthcareservices::where('healthcareservice_id',$HCS_id)->first();
        $data['healthcare_servicetype_name'] = $data['healthcareservices']->healthcareservicetype_id;
        $data['facilityPatientUser'] = facilityPatientUser::where('facilitypatientuser_id',$data['healthcareservices']->facilitypatientuser_id)->first();
        $data['facilityUser'] = facilityUser::where('facilityuser_id',$data['facilityPatientUser']->facilityuser_id)->first();
        $data['Patients'] = Patients::where('patient_id',$data['facilityPatientUser']->patient_id)->first();
        $data['Users'] = Users::where('user_id',$data['facilityUser']->user_id)->first();
        $data['Facilities'] = Facilities::where('facility_id',$data['facilityUser']->facility_id)->first();

        // echo "<pre>"; print_r($data); echo "</pre>";
        return $data;
    }
    /**
     * Data from facility id
     * @param string $facility_id facility id
     * @return  array
     */
    public function DataFromFacility($facility_id) {
        $data['facilityUser'] = facilityUser::where('facility_id',$facility_id)->lists('facilityuser_id');
        $data['facilityPatientUser'] = facilityPatientUser::whereIn('facilityuser_id',$data['facilityUser'])->lists('facilitypatientuser_id');
        $data['healthcareservices'] = Healthcareservices::whereIn('facilitypatientuser_id',$data['facilityPatientUser'])->lists('healthcareservice_id');
        return $data;
    }

    /**
     * Create Referral
     * @param  string $healthcareId
     * @return array
     */
    public function createreferral($healthcareId) {
        $data['facilityid'] = $c_facility_id = $this->facilitySession()->facility_id;
        $facilityPatientUserId = Healthcareservices::where('healthcareservice_id', $healthcareId)->select('facilitypatientuser_id','healthcareservicetype_id','encounter_datetime')->get();
        foreach ($facilityPatientUserId as $key => $value) {
            $patientid = facilityPatientUser::where('facilitypatientuser_id', $value->facilitypatientuser_id)->pluck('patient_id');

            $data['Patients'] = Patients::where('patient_id', $patientid)->first();
            $data['Patients']->healthcare_servicetype_name = $value->healthcareservicetype_id;
            $data['Patients']->encounter_datetime = $value->encounter_datetime;
            $data['Patients']->healthcareId = $healthcareId;

        }
        $data['lovReferralReasons'] = LovReferralReasons::all();
        $data['facilities'] = Facilities::with('facilityContact')->whereNotIn('facility_id', [$c_facility_id])->orderBy('facility_name')->get();
        // echo "<pre>"; print_r($data); echo "</pre>";
        return view('referrals::createreferral')->with($data);
    }

    /**
     * Create Referral: Save to database
     * With email sending
     */
    public function add(ReferralsFormRequest $request) {
        $data = Input::all();
        $newId = IdGenerator::generateId();
        $referrer_facility = $this->facilitySession()->facility_id; /*** referrer - from session **/
        $facility = Input::has('facility') ? Input::get('facility')  : false; /*** selected facilities - referred to **/
        $ReferralReasons = Input::has('ReferralReasons') ? Input::get('ReferralReasons')  : false;

        if($facility) {
            $facility_details = json_decode($facility);

            foreach ($facility_details as $key => $value) {
                $referral_id = $newId.$key.$key;

                $referrals = new Referrals();
                $referrals->referral_id = $referral_id;
                $referrals->facility_id = $value;
                $referrals->urgency = Input::has('Urgency') ? Input::get('Urgency')  : false;

                $referrals->method_transport = Input::has('MethodofTransport') ? Input::get('MethodofTransport')  : false;
                $referrals->management_done = Input::has('ManagementDone') ? Input::get('ManagementDone')  : false;
                $referrals->medical_given = Input::has('MedicalGiven') ? Input::get('MedicalGiven')  : false;
                $referrals->referral_remarks = Input::has('ReferralRemarks') ? Input::get('ReferralRemarks')  : false;

                if(Input::get('send')) {
                    $referrals->referral_status = '1'; //SENT
                } else {
                    $referrals->referral_status = '6'; //save as DRAFT
                }

                $referrals->healthcareservice_id = Input::has('healthcareId') ? Input::get('healthcareId')  : false;
                $referralssave = $referrals->save();

                if($ReferralReasons) {
                    foreach ($ReferralReasons as $k => $v) {
                        $referralReasons = new referralReasons();

                        $referralReasons->referralreason_id = $newId.$k.$key;
                        $referralReasons->referral_id = $referral_id;
                        $referralReasons->lovreferralreason_id = $v;

                        // echo "<pre>"; print_r($referralReasons); echo "</pre>";
                        $referralReasonssave = $referralReasons->save();
                    }
                }
                $patientId = Input::has('patientId') ? Input::get('patientId')  : false;

                if($referralssave && $referralReasonssave) {
                    $subject = 'SHINE OS+: Referred Patient';
                    $message = 'Referral';
                    $emailSending = $this->sendToEmail($referral_id, 'add', $subject, $message, 1);

                    Session::flash('alert-class', 'alert-success');
                    $message = 'Successfully added';
                } else {
                    Session::flash('alert-class', 'alert-danger');
                    $message = 'Failed to add';
                }
            }
            return Redirect::to($this->modulePath)->with('message', $message)->withInput();
        }
    }

    /**
     * Send or Discard referrals from drafts
     * @param  string $id referral id
     * @return string
     */
    public function senddiscard($id) {
        $status = Input::has('send') ? Input::get('send')  : Input::get('discard');
        $message = $this->updateReferralStatus($id,$status);
        return Redirect::to($this->modulePath)->with('message', $message);
        // echo "<pre>"; print_r($data['Patients']->patient_id); echo "</pre>";
    }

    /**
     * Accept or Decline referrals from inbound
     * @param  string $id referral id
     * @return string
     */
    public function acceptdecline($id) {
        $status = Input::has('accept') ? Input::get('accept')  : Input::get('decline');
        $message = $this->updateReferralStatus($id,$status);
        return Redirect::to($this->modulePath)->with('message', $message);
    }

    /**
     * Send or discard referrals from drafts and accept or decline referrals from inbound
     * @param  string $id       referral id
     * @param  string $status   Send, Discard, Decline and Accept
     * @return string $message
     */
    public function updateReferralStatus($id,$status) {
        if($status=='Send') {
            $affectedRows = Referrals::where('referral_id', $id)->update(['referral_status' => 1]);
            $type = 'Sent';
        } elseif($status=='Discard') {
            $affectedRows = Referrals::where('referral_id', $id)->delete();
            $type = 'Discarded';
        } elseif($status=='Decline') {
            $affectedRows = Referrals::where('referral_id', $id)->update(['referral_status' => 2]);
            $type = 'Declined';
        } elseif($status=='Accept') {
            $affectedRows = Referrals::where('referral_id', $id)->update(['referral_status' => 3]);
            $type = 'Accepted';
        } else {
            $affectedRows = false;
        }

        if($affectedRows) {
            $referral_message = 'Your referral has been '.$type;
            if($status=='Accept' || $status=='Decline') {
                $referral_subject = 'SHINE OS+: Referral Status';
                $referrer = 0;
                $typ = 'reply';
            } elseif($status=='Send') {
                $referral_subject = 'SHINE OS+: Referred Patient';
                $referrer = 1;
                $typ = 'follow';
            } else {}
            if($status!='Discard') {
                // $response = $this->sendToEmail($id, $typ, $referral_subject, $referral_message, $referrer);
            }
            Session::flash('alert-class', 'alert-success');
            $message = 'Successfully '.$type;
        } else {
            Session::flash('alert-class', 'alert-danger');
            $message = 'Failed to update your referral status.';
        }

        return $message;
    }

     /**
      * Follow up to referral
      * @param  string $referral_id
      * @return string message
      */
    public function addfollowup($referral_id) {
        $type = 'follow';
        $referral_subject = 'SHINE OS+ referral follow-up';
        $referral_message = 'A follow-up is being ask for the consultation referral forward to you.';
        $referral_message_status = 1;
        $referrer = 1;

        $message = $this->refMessageToDB($type, $referral_id, $referral_subject, $referral_message, $referral_message_status, $referrer);

        // echo "<pre>"; print_r($response); echo "</pre>";
        return Redirect::to($this->modulePath)->with('message', $message);
    }

    /**
     * Response to follow up referral
     * @param  string $referral_id
     * @return string
     */
    public function replyToFollowUp($referral_id) {
        $referral_message = Input::has('replyMessage') ? Input::get('replyMessage') : FALSE;
        if($referral_message){
            $current_facilityid = $this->facilitySession()->facility_id;
            $type = 'reply';
            $referral_subject = 'SHINE OS+ reply to your referral';

            $referral_message_status = 1;
            $referralDetails = Referrals::where('referral_id', $referral_id)->first();
            if($current_facilityid == $referralDetails['facility_id']) {
                $referrer = 0;
            } else {
                $referrer = 1;
            }
            $message = $this->refMessageToDB($type, $referral_id, $referral_subject, $referral_message, $referral_message_status, $referrer);
        } else {
            Session::flash('alert-class', 'alert-danger');
            $message = 'Fill out required field';

        }
        return Redirect::to($this->modulePath)->with('message', $message);
    }

    /**
     * Follow up and response data, save to Database
     * @param  int      $type           Follow up or Reply
     * @param  string   $referral_id
     * @param  string   $referral_subject
     * @param  string   $referral_message
     * @param  string   $referral_message_status
     * @param  boolean  $referrer
     * @return string   $message
     */
    public function refMessageToDB($type, $referral_id, $referral_subject, $referral_message, $referral_message_status, $referrer) {
        $newId = IdGenerator::generateId();

        $referralmessages = new referralmessages();
        $referralmessages->referralmessage_id = $newId;
        $referralmessages->referral_id = $referral_id;
        $referralmessages->referral_subject = $referral_subject;
        $referralmessages->referral_message = $referral_message;
        $referralmessages->referral_message_status = $referral_message_status;
        $referralmessages->referrer = $referrer;
        $refStat = $referralmessages->save();

        if($type == 'follow') {
            if($refStat) {
                $response = $this->sendToEmail($referral_id, $type, $referral_subject, $referral_message, $referrer);
                $alert = "alert-success";
                $message = 'Successfully sent a follow-up';
            } else {
                $alert = "alert-danger";
                $message = 'Failed to send a follow-up';
            }
        } else {
            if($refStat) {
                $response = $this->sendToEmail($referral_id, $type, $referral_subject, $referral_message, $referrer);
                $alert = "alert-success";
                $message = 'Successfully sent a reply';
            } else {
                $alert = "alert-danger";
                $message = 'Failed to send a reply';
            }
        }

        Session::flash('alert-class', $alert);
        return $message;
    }

    /**
     * Dynamic Email Sending for Referrals
     * @param  string $referral_id referral id
     * @param  string $type        add, follow, reply
     * @param  string $subject     subject line of email
     * @param  string $message     body message of email
     * @param  string $referrer    referrer true or false
     * @return boolean
     */
    public function sendToEmail($referral_id, $type, $subject=null, $message=null, $referrer) {
        $current_facilityid = $this->facilitySession()->facility_id;
        $current_userid = $this->userSession()->user_id;

        $referralDetails = Referrals::where('referral_id', $referral_id)->first();
        $DataFromReferrer = $this->DataFromHealthCare($referralDetails['healthcareservice_id']);
        $DataFromReferredTo = Facilities::where('facility_id', $referralDetails['facility_id'])->first();

        if($type == 'add' || $type == 'follow' || $referrer == 1) { /*** add referral or Send a follow up*/
            $ToFacilityId = $DataFromReferredTo['facility_id'];
            $FromFacilityId = $DataFromReferrer['Facilities']->facility_id;
        } elseif($type == 'reply' && $referrer == 0) { /*** reply to follow up */
            $ToFacilityId = $DataFromReferrer['Facilities']->facility_id;
            $FromFacilityId = $DataFromReferredTo['facility_id'];
        } else {
            $ToFacilityId = NULL;
            $FromFacilityId = NULL;
        }

        /** send to Users */
        $toFacilityUser = facilityUser::where('facility_id', $ToFacilityId)->lists('user_id');
        $toUserData = Users::whereIn('user_id',$toFacilityUser)->get();
        foreach ($toUserData as $key => $value) {
            $data['useremail'] = $value->email;
            $data['userfirst_name'] = $value->first_name;
            $data['usermiddle_name'] = $value->middle_name;
            $data['userlast_name'] = $value->last_name;

            $data['healthcare_servicetype_name'] = $DataFromReferrer['healthcare_servicetype_name'];

            $data['reasons'] = referralReasons::where('referral_id',$referral_id)->select('lovreferralreason_id')->get();
            foreach ($data['reasons'] as $kreason => $vreason) {
                $refreasonid = $vreason['lovreferralreason_id'];
                $vreason->reasondesc = $this->referralReasons[$refreasonid];
            }

            $data['p_first_name'] = $DataFromReferrer['Patients']->first_name;
            $data['p_middle_name'] = $DataFromReferrer['Patients']->middle_name;
            $data['p_last_name'] = $DataFromReferrer['Patients']->last_name;

            $data['referrer'] = $DataFromReferrer['Facilities']->facility_name;
            $data['referred_to'] = $DataFromReferredTo['facility_name'];

            $data['msg'] = $message;
            $data['subject'] = $subject;
            $data['type'] = $type;

            $response = EmailHelper::SendReferralMessage($data);
            // $response = TRUE;
        }
        // echo "<pre>"; print_r($data); echo "</pre>";
        return $response;
    }

}
