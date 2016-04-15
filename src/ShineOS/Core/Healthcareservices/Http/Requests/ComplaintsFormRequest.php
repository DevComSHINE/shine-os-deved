<?php namespace ShineOS\Core\Healthcareservices\Http\Requests;

use Response;
use Illuminate\Foundation\Http\FormRequest;

class ComplaintsFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'complaint'     => 'required|max:500|min:10'
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
