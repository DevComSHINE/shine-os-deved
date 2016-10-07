<?php
/* Functions for Referrals */

use ShineOS\Core\Referrals\Entities\Referrals;
use ShineOS\Core\Referrals\Entities\Referralmessages as referralmessages;
use ShineOS\Core\Facilities\Entities\FacilityUser as facilityUser;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser as facilityPatientUser;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;

function countInboundReferrals($facility_id)
{
    $referrals = DB::table('referrals')
        ->where('facility_id', $facility_id)
        ->get();

    return count($referrals);
}

function countOutboundReferrals($facility_id)
{
    $o = 0;
    //get all my healthcare records
    $hcs = getAllHealthcareByFacilityID($facility_id);

    if($hcs) {
        foreach($hcs as $h){
            $referrals = DB::table('referrals')
            ->where('healthcareservice_id', $h->healthcareservice_id)
            ->get();

            if($referrals) {
                $o += count($referrals);
            }
        }
    }

    return $o;
}

function countReferralMessages($facility_id)
{
    /*//count inbound
    $in = DB::table('referrals')
        ->join('referral_messages', 'referral_messages.referral_id', '=', 'referrals.referral_id')
        ->where('facility_id', $facility_id)
        ->get();
    $o = count($in);

    //count outbound
    $hcs = getAllHealthcareByFacilityID($facility_id);
    foreach($hcs as $h){
        $out = DB::table('referrals')
        ->join('referral_messages', 'referral_messages.referral_id', '=', 'referrals.referral_id')
        ->where('healthcareservice_id', $h->healthcareservice_id)
        ->get();

        if($out) {
            $o += count($out);
        }
    }*/
    $ref_facility_id = Session::get('facility_details')->facility_id;

    $data['facilityUser'] = facilityUser::where('facility_id',$ref_facility_id)->lists('facilityuser_id');
    $data['facilityPatientUser'] = facilityPatientUser::whereIn('facilityuser_id',$data['facilityUser'])->lists('facilitypatientuser_id');
    $data['healthcareservices'] = Healthcareservices::whereIn('facilitypatientuser_id',$data['facilityPatientUser'])->lists('healthcareservice_id');
    $allreferrals = Referrals::WhereIn('healthcareservice_id',$data['healthcareservices'])->orWhere('facility_id',$ref_facility_id)->lists('referral_id');
    $refMessages = referralmessages::whereIn('referral_id',$allreferrals)->orderBy('updated_at', 'DESC')->groupBy('referral_id')->lists('referral_id');
    return $refMessages->count();

    

    // $in = DB::table('referral_messages_view')
    //     ->where('referree_id', $facility_id)
    //     ->get();

    // $out = DB::table('referral_messages_view')
    //     ->where('referrer_id', $facility_id)
    //     ->get();

    // $o = count($in) + count($out);

    // //return total
    // return $o;
}

function countDraftReferrals($facility_id)
{
    $o = 0;
    /*//get all my healthcare records
    $hcs = DB::table('healthcare_services')
        ->join('facility_patient_user', 'healthcare_services.facilitypatientuser_id', '=', 'facility_patient_user.facilitypatientuser_id')
        ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
        ->where('facility_user.facility_id', $facility_id)
        ->where('facility_patient_user.deleted_at', NULL)
        ->get();

    foreach($hcs as $h){
        $referrals = DB::table('referrals')
        ->where('healthcareservice_id', $h->healthcareservice_id)
        ->where('referral_status', 6)
        ->get();

        if($referrals) {
            $o += count($referrals);
        }
    }*/

    $referrals = DB::table('referrals_view')
        ->where('referral_status', 6)
        ->where('facility_id', $facility_id)
        ->where('deleted_at', NULL)
        ->get();
    $o = count($referrals);

    return $o;
}
