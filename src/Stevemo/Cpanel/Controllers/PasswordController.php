<?php  namespace Stevemo\Cpanel\Controllers; 

use View, Config, Input, Redirect, Mail, Event;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;

class PasswordController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    private $users;

    /**
     * @param CpanelUserInterface $users
     */
    public function __construct(CpanelUserInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Display the reset password form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function getForgot()
    {
        return View::make(Config::get('cpanel::views.password_forgot'));
    }

    /**
     * Find the user and send a email with the reset code
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postForgot()
    {
        try
        {
            $email = Input::get('email');
            $user = $this->users->findByLogin($email);
            $token = $user->getResetPasswordCode();
            $view = Config::get('cpanel::views.email_password_forgot');

            Mail::queue($view, compact('token'), function($message) use ($email)
            {
                $message->to($email)->subject('Account Password Reset');
            });

            Event::fire('users.password.forgot', array($user));
            
            return View::make(Config::get('cpanel::views.password_send'))
                ->with('email', $email);
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()
                ->with('password_error', $e->getMessage());
        }
    }

}
