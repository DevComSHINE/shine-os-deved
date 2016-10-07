<?php namespace ShineOS\Core\Healthcareservices\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class DispositionFormRequest extends FormRequest 
{
    public function rules()
    {   
        return [
            'disposition'     => 'required',
            'discharge_condition'     => 'required_with_all:disposition',
            'date'     => 'required_with_all:discharge_condition',
            'time'     => 'required_with_all:date',
            'discharge_notes' => 'required_with_all:time'
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
