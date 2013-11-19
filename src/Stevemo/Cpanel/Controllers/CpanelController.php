<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Input, Redirect, Lang;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Form\UserFormInterface;


class CpanelController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    private $users;

    /**
     * @var \Stevemo\Cpanel\User\Form\UserFormInterface
     */
    private $userForm;

    /**
     * @param CpanelUserInterface                         $users
     * @param \Stevemo\Cpanel\User\Form\UserFormInterface $userForm
     */
    public function __construct(CpanelUserInterface $users, UserFormInterface $userForm)
    {
        $this->users = $users;
        $this->userForm = $userForm;
    }


    /**
     * Show the dashboard
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return View::make(Config::get('cpanel::views.dashboard'));
    }

    /**
     * Show the login form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        return View::make(Config::get('cpanel::views.login'), compact('login_attribute'));
    }

    /**
     * Display the registration form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        return View::make(Config::get('cpanel::views.register'), compact('login_attribute'));
    }

    /**
     * Logs out the current user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->users->logout();
        return Redirect::route('cpanel.login')
            ->with('success', Lang::get('cpanel::users.logout'));
    }

    /**
     * Authenticate the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        $remember = Input::get('remember_me', false);
        $userdata = array(
            Config::get('cartalyst/sentry::users.login_attribute') => Input::get('login_attribute'),
            'password' => Input::get('password')
        );

        if ( $this->userForm->login($userdata,$remember) )
        {
            return Redirect::intended(Config::get('cpanel::prefix', 'admin'))
                ->with('success', Lang::get('cpanel::users.login_success'));
        }

        return Redirect::back()
            ->withInput()
            ->with('login_error',$this->userForm->getErrors()->first());


    }

    /**
     * Register user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
        if( $this->userForm->register(Input::all(),false) )
        {
            return Redirect::route('cpanel.login')
                ->with('success', Lang::get('cpanel::users.register_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->userForm->getErrors());

    }
    
}