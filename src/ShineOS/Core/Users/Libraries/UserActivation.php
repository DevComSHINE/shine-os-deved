<?php namespace ShineOS\Core\Users\Libraries;

Use Mail, Session, Redirect;

class UserActivation {

    function __construct(){
    }


    /**
     * Generate random password
     *
     * @return string
     */
    public static function generateActivationCode ( $email = '' )
    {
        return $generatedKey = sha1(mt_rand(10000,99999).time().$email);
    }

    /**
     * Generate user account activation link
     *
     * @return string
     */
    public static function sendUserActivationCode ( $user, $temporary_password = '' ) {
        $contactName = 'SHINE OS+ Administrator';
        $contactEmail = 'support@shineos.com';
        $activation_link = url("activateaccount/user/{$user->activation_code}");

        $data = array(
            'name' => "{$user->first_name} {$user->last_name}",
            'email' => $user->email,
            'activation_link' => $activation_link,
            'temporary_password' => $temporary_password
        );
        Mail::send('users::emails.activation_code', $data, function($message) use ($contactEmail, $contactName, $user, $temporary_password)
        {
            $message->from($contactEmail, $contactName);
            $message->to($user->email, "{$user->first_name} {$user->last_name}")->subject('SHINE OS+ Account Activation');
        });
    }


    /**
     * Generate user account activation link
     *
     * @return string
     */
    public static function sendAdminActivationCode ( $user, $type = NULL ) {
        $contactName = 'SHINE OS+ Administrator';
        $contactEmail = 'support@shineos.com';
        if($type == 'ce') {
            $activation_link = url("activateaccount/admin/ce/{$user->activation_code}");
        } else {
            $activation_link = url("activateaccount/admin/cloud/{$user->activation_code}");
        }

        $data = array(
            'name' => "{$user->first_name} {$user->last_name}",
            'email' => $user->email,
            'activation_link' => $activation_link
        );
        Mail::send('users::emails.admin_activation', $data, function($message) use ($contactEmail, $contactName, $user)
        {
            $message->from($contactEmail, $contactName);
            $message->to($user->email, "{$user->first_name} {$user->last_name}")->subject('SHINE OS+ Account Activation');
        });
    }

    /**
     * Generate user account activation link
     *
     * @return string
     */
    public static function sendAdminCEActivationCode ( $user, $file ) {
        $contactName = 'SHINE OS+ Administrator';
        $contactEmail = 'support@shine.ph';

        $data = array(
            'name' => "{$user->first_name} {$user->last_name}",
            'email' => $user->email,
            'code' => $file.'.txt'
        );

        Mail::send('users::emails.admin_ce_activation', $data, function($message) use ($contactEmail, $contactName, $user, $file)
        {
            $message->from($contactEmail, $contactName);
            $message->to($user->email, "{$user->first_name} {$user->last_name}")->subject('Welcome to ShineOS+ Community Edition');
            $message->attach( 'public/uploads/'.$file.'.txt' );
        });
    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
