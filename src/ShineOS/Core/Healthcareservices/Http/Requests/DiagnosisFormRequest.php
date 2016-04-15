<?php namespace ShineOS\Core\Healthcareservices\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class DiagnosisFormRequest extends FormRequest 
{
    public function rules()
    {   
        return [];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    } 
}