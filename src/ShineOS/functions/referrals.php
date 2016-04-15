<?php
/* Functions for Referrals */

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

    foreach($hcs as $h){
        $referrals = DB::table('referrals')
        ->where('healthcareservice_id', $h->healthcareservice_id)
        ->get();

        if($referrals) {
            $o += count($referrals);
        }
    }

    return $o;
}

function countReferralMessages($facility_id)
{
    //count inbound
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
    }

    //return total
    return $o;
}

function countDraftReferrals($facility_id)
{
    $o = 0;
    //get all my healthcare records
    $hcs = DB::table('healthcare_services')
        ->join('facility_patient_user', 'healthcare_services.facilitypatientuser_id', '=', 'facility_patient_user.facilitypatientuser_id')
        ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
        ->where('facility_user.facility_id', $facility_id)
        ->get();

    foreach($hcs as $h){
        $referrals = DB::table('referrals')
        ->where('healthcareservice_id', $h->healthcareservice_id)
        ->where('referral_status', 6)
        ->get();

        if($referrals) {
            $o += count($referrals);
        }
    }

    return $o;
}
