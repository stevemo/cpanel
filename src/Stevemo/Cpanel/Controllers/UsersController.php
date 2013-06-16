<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Config;
use Redirect;
use Lang;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserSuspendedException;
use Cartalyst\Sentry\Users\UserBannedException;

class UsersController extends BaseController {

    /**
     * Show all the users
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return Response 
     */
    public function index()
    {
        $users = Sentry::getUserProvider()->findAll();
        return View::make('cpanel::users.index', compact('users'));
    }

    /**
     * Show a user profile
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  int $id 
     * @return Response 
     */
    public function show($id)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($id);
            return View::make(Config::get('cpanel::views.users_show'),compact('user'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display add user form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function create()
    {
        return View::make(Config::get('cpanel::views.users_create'));
    }

    /**
     * Create a new user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function store()
    {
        try
        {
            $validation = $this->getValidationService();

            if( $validation->passes() )
            {
                //create the user
                $user = Sentry::getUserProvider()->create($validation->getData());
                return Redirect::route('admin.users.index')->with('success', Lang::get('cpanel::users.create_success'));
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

    /**
     * get the validation service
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return Object 
     */
    private function getValidationService()
    {
        $class = '\\'.ltrim(Config::get('cpanel::validation.user'), '\\');
        return new $class;
    }
}