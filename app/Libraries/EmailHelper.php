<?php namespace Shine\Libraries;

Use Mail, Session, Redirect;

class EmailHelper
{

    function __construct () {

    }

    /**
     * Just a test email function
     *
     * @return response
     */
    public static function sendBasicEmail ( $_param = array() ) {
        $contactName = 'SHINE Support';
        $contactEmail = 'support@shine.ph';
        $recipient = array();
        $recipient['name'] = isset($_param['recipient_name']) ? $_param['recipient_name'] : 'Recipient Name';
        $recipient['email'] = isset($_param['recipient_email']) ? $_param['recipient_email'] : 'test_recipient@test.com';

        $data = array(
            'name' => isset($_param['name']) ? $_param['name'] : 'Name here',
            'email' => isset($_param['email']) ? $_param['email'] : 'test@test.com',
            'email_body' => isset($_param['email_body']) ? $_param['email_body'] : ''
        );
        Mail::send('emails.basic_email', $data, function($message) use ($contactEmail, $contactName, $recipient, $_param)
        {
            $subject = isset($_param['subject']) ? $_param['subject'] : 'Subject here';
            $message->from($contactEmail, $contactName);
            $message->to($recipient['email'], "{$recipient['name']}")->subject($subject);
        });
    }

    public static function sendForgotPasswordEmail ( $_param = array() )
    {
        $email = isset($_param['email']) ? $_param['email'] : '';
        $forgot_password_code = isset($_param['forgot_password_code']) ? $_param['forgot_password_code'] : '';
        $changepassword_link = isset($_param['changepassword_link']) ? $_param['changepassword_link'] : '';
        $data = array(
            'email' => $_param['email'],
            'forgot_password_code' => $_param['forgot_password_code'],
            'changepassword_link' => $_param['changepassword_link'],
        );

        Mail::send('users::emails.change_password', $data, function($message) use ($email, $changepassword_link, $forgot_password_code)
        {
            $message->from($email, $email);
            $message->to($email, $email)->subject('ShineOS+ Change Password Request');
        });

    }

    public static function SendReferralMessage($details) {
        $contactName = 'SHINE Support';
        $contactEmail = 'support@shine.ph';
        $data = array(
            'referrer' => $details['referrer'],
            'referred_to' => $details['referred_to'],
            'p_first_name' => $details['p_first_name'],
            'p_middle_name' => $details['p_middle_name'],
            'p_last_name' => $details['p_last_name'],
            'msg' => $details['msg'],
            'reasons' => $details['reasons'],
            'type' => $details['type'],
            'healthcare_servicetype_name' => $details['healthcare_servicetype_name']
        );

        Mail::send('referrals::emails.referred', $data, function($message) use ($contactEmail, $contactName, $details)
        {
            $message->from($contactEmail, $contactName);
            $message->to($details['useremail'], "'".$details['userfirst_name'].$details['userlast_name']."'")->subject('ShineOS+ Referrals: '.$details['subject']);
        });

        if(count(Mail::failures()) > 0){
           return false;
        } else {
            return true;
        }
    }

    public static function SendReminderMessage($details) {
        $contactName = 'SHINE Support';
        $contactEmail = 'support@shine.ph';
        Mail::send('reminders::emails.remind', $details, function($message) use ($contactEmail, $contactName, $details)
        {
            $message->from($contactEmail, $contactName);
            $message->to($details['toUser_email'], $details['toUser_name'])->subject('ShineOS+ Reminders: '.$details['subj']);
        });

        if(count(Mail::failures()) > 0){
           return false;
        } else {
            return true;
        }
    }


}
