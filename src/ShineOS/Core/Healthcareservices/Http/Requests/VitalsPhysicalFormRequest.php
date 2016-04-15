<?php namespace ShineOS\Core\Healthcareservices\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class VitalsPhysicalFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'temperature'     => array('required','regex:/[\d]*,?[\d]*/'),
            'heart_rate'     => 'numeric',
            'bloodpressure_systolic'     => 'integer',
            'bloodpressure_diastolic'     => 'integer',
            'height'     => 'numeric',
            'weight'     => 'numeric',
            'waist'     => 'numeric'
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
