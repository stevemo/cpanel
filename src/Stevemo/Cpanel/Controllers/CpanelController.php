<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Config;
use Input;
use Sentry;
use Redirect;
use Lang;
use Event;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;


class CpanelController extends BaseController {


    /**
     * Show the dashboard
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return Response 
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
     * @return Response 
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
     * @return Response
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
        if (Sentry::check())
        {
            $user = Sentry::getUser();
            Sentry::logout();
            Event::fire('users.logout', array($user));
            return Redirect::route('admin.login')->with('success', Lang::get('cpanel::users.logout'));
        }
        return Redirect::route('admin.login');
    }

    /**
     * Authenticate the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return Response
     */
    public function postLogin()
    {
        try
        {
            $remember = Input::get('remember_me', false);
            $userdata = array(
                Config::get('cartalyst/sentry::users.login_attribute') => Input::get('login_attribute'),
                'password' => Input::get('password')
            );

            $user = Sentry::authenticate($userdata, $remember);
            Event::fire('users.login', array($user));
            return Redirect::intended('admin')->with('success', Lang::get('cpanel::users.login_success'));
        }
        catch (LoginRequiredException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (WrongPasswordException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserNotActivatedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserSuspendedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
        catch (UserBannedException $e)
        {
            return Redirect::back()->withInput()->with('login_error',$e->getMessage());
        }
    }

    /**
     * Register user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function postRegister()
    {
        try
        {
            $validation = $this->getValidationService('user');

            if( $validation->passes() )
            {
                //TODO : Do something with the activation code later on
                //TODO : Setting to activate or not, email also
                $user = Sentry::register($validation->getData(), true);
                Event::fire('users.register', array($user));
                
                return Redirect::route('admin.login')->with('success', Lang::get('cpanel::users.register_success')); 
            }
           
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        catch (LoginRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
        catch (UserExistsException $e)
        {
            return Redirect::back()->withInput()->with('error',$e->getMessage());
        }
    }
    
}