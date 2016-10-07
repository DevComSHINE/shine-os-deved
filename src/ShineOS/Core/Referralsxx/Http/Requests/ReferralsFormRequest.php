<?php namespace ShineOS\Core\Referrals\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class ReferralsFormRequest extends FormRequest 
{
    public function rules()
    {   
        return [
            'patientId'     => 'required',
            'healthcareId'  => 'required',
            'facility'      => 'required',
            'Urgency'         => 'required',
            'ReferralReasons' => 'required',
            'MethodofTransport' => 'required',
            'ManagementDone' => 'required',
            'MedicalGiven' => 'required',
            'ReferralRemarks' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'patientId.required' => 'Patient name is required',
            'healthcareId.required' => 'Healthcare service is required',
            'facility.required' => 'Check a Facility from the list',
            'Urgency.required' => 'Choose urgency from the list',
            'ReferralReasons.required' => 'Check a referral reason from the list',
            'MethodofTransport.required' => 'Method of transport is required',
            'ManagementDone.required' => 'Management done is required',
            'MedicalGiven.required' => 'Medical given is required',
            'ReferralRemarks.required' => 'Referral remarks is required' 
        ];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    } 
}