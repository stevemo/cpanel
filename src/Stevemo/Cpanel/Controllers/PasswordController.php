<?php  namespace Stevemo\Cpanel\Controllers; 

use View, Config, Input, Redirect, Mail, Event, Lang;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;
use Stevemo\Cpanel\User\Form\PasswordFormInterface;

class PasswordController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    private $users;

    /**
     * @var \Stevemo\Cpanel\User\Form\PasswordFormInterface
     */
    private $passForm;

    /**
     * @param CpanelUserInterface                             $users
     * @param \Stevemo\Cpanel\User\Form\PasswordFormInterface $passForm
     */
    public function __construct(CpanelUserInterface $users, PasswordFormInterface $passForm)
    {
        $this->users = $users;
        $this->passForm = $passForm;
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
            $this->passForm->forgot($email);
            return View::make(Config::get('cpanel::views.password_send'))
                ->with('email', $email);
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()
                ->with('password_error', $e->getMessage());
        }
    }

    /**
     * Display the password reset form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $code
     *
     * @return \Illuminate\View\View
     */
    public function getReset($code)
    {
        return View::make(Config::get('cpanel::views.password_reset'))
            ->with('code',$code);
    }

    /**
     *
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset()
    {
        $creds = array(
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
            'code' => Input::get('code')

        );

        if ($this->passForm->reset($creds))
        {
            return Redirect::route('cpanel.login')
                ->with('success', Lang::get('cpanel::users.password_reset_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->passForm->getErrors());
    }

}
