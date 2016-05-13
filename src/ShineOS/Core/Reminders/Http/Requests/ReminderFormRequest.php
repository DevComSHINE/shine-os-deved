<?php namespace ShineOS\Core\Reminders\Http\Requests;

use Response;

use Illuminate\Foundation\Http\FormRequest;

class ReminderFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'reminder-type'     => 'required',
            'message'           => 'required|min:5|max:450',
            'date'              => 'required',
            'reminder_email'    => 'required_without_all:reminder_mobile|reminder_email',
            'reminder_mobile'   => 'required_without_all:reminder_email|max:20|min:10'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
