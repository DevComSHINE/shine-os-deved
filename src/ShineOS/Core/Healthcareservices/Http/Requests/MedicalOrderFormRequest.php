<?php namespace ShineOS\Core\Healthcareservices\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class MedicalOrderFormRequest extends FormRequest 
{
    public function rules()
    {   
        return [
            'prescription.Drug_Code' => 'alpha_num',
            'prescription.Drug_Brand_Name' => 'alpha_num',
            'prescription.Dose_Qty' => 'numeric',
            'prescription.Total_Quantity' => 'numeric',
            'prescription.Remarks' => 'alpha_num',

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