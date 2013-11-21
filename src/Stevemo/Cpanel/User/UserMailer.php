<?php  namespace Stevemo\Cpanel\User; 

use Cartalyst\Sentry\Users\UserInterface;
use Mail, Config;

class UserMailer implements UserMailerInterface {

    /**
     * Send a email to a given user with a link to reset is password
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function sendReset(UserInterface $user)
    {
        $view = Config::get('cpanel::views.email_password_forgot');
        $code = $user->getResetPasswordCode();

        Mail::queue($view, compact('code'), function($message) use ($user)
        {
            $message->to($user->email)->subject('Account Password Reset');
        });
    }
}