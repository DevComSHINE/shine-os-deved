<?php namespace ShineOS\Core\Reminders\Http\Requests;

use Response;

use Illuminate\Foundation\Http\FormRequest;

class BroadcastFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'reminder-reminder_type'   => 'required',
            'message'               => 'required|min:5|max:450',
            'subject'               => 'required|min:5',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
