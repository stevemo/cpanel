<?php namespace Stevemo\Cpanel\Controllers;

use Cartalyst\Sentry\Users\UserAlreadyActivatedException;
use View;
use Config;
use Redirect;
use Lang;
use Input;
use Event;
use Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;


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
        $users = Sentry::getUserProvider()->createModel()->with('groups')->get();
        return View::make(Config::get('cpanel::views.users_index'), compact('users'));
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
     * Display the user edit form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try
        {
            $user   = Sentry::getUserProvider()->findById($id);
            $groups = Sentry::getGroupProvider()->findAll();

            //get only the group id the user belong to
            $userGroupsId = array_pluck($user->getGroups()->toArray(), 'id');

            return View::make(Config::get('cpanel::views.users_edit'),compact('user','groups','userGroupsId'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error',$e->getMessage());
        }
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
            $validation = $this->getValidationService('user');

            if( $validation->passes() )
            {
                //create the user
                $user = Sentry::register($validation->getData(), true);
                Event::fire('users.create', array($user));
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
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        try
        {
            $credentials = Input::except('groups');
            $credentials['id'] = $id;

            $validation = $this->getValidationService('user', $credentials);

            if( $validation->passes() )
            {
                $user = Sentry::getUserProvider()->findById($id);
                $user->fill($validation->getData());
                $user->save();

                //update groups
                $user->groups()->detach();
                $user->groups()->sync(Input::get('groups',array()));

                Event::fire('users.update', array($user));
                return Redirect::route('admin.users.index')->with('success', Lang::get('cpanel::users.update_success'));
            }

            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        catch ( UserExistsException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
        catch ( LoginRequiredException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $currentUser = Sentry::getUser();

        if ($currentUser->id === (int) $id)
        {
            return Redirect::back()->with('error', Lang::get('cpanel::users.delete_denied') );
        }

        try
        {
            $user = Sentry::getUserProvider()->findById($id);
            $eventData = $user;
            $user->delete();
            Event::fire('users.delete', array($eventData));
            return Redirect::route('admin.users.index')->with('success',Lang::get('cpanel::users.delete_success'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error',$e->getMessage());
        }
    }

    /**
     * activate or deactivate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putStatus($id)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($id);

            if ($user->isActivated())
            {
                $user->activated = 0;
                $user->activated_at = null;
                $user->save();
                return Redirect::route('admin.users.index')->with('success',Lang::get('cpanel::users.deactivation_success'));
            }
            else
            {
                $code = $user->getActivationCode();

                if ($user->attemptActivation($code))
                {
                    // User activation passed
                    return Redirect::route('admin.users.index')->with('success',Lang::get('cpanel::users.activation_success'));
                }
                else
                {
                    // User activation failed
                    return Redirect::route('admin.users.index')->with('error',Lang::get('cpanel::users.activation_fail'));
                }
            }
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error',$e->getMessage());
        }
        catch (UserAlreadyActivatedException $e)
        {
            return Redirect::route('admin.users.index')->with('error',$e->getMessage());
        }
    }

}
