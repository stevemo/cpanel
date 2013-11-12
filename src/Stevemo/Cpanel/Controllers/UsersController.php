<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Redirect, Lang, Input;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Form\UserFormInterface;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\Group\Repo\GroupInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;
use Cartalyst\Sentry\Users\UserAlreadyActivatedException;

class UsersController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    protected $users;

    /**
     * @var \Stevemo\Cpanel\Permission\Form\PermissionFormInterface
     */
    protected $permissions;

    /**
     * @var \Stevemo\Cpanel\Group\Repo\GroupInterface
     */
    protected $groups;

    /**
     * @var \Stevemo\Cpanel\User\Form\UserFormInterface
     */
    protected $userForm;

    /**
     * @param \Stevemo\Cpanel\User\Repo\CpanelUserInterface       $users
     * @param \Stevemo\Cpanel\Permission\Repo\PermissionInterface $permissions
     * @param \Stevemo\Cpanel\Group\Repo\GroupInterface           $groups
     * @param \Stevemo\Cpanel\User\Form\UserFormInterface         $userForm
     */
    public function __construct(
        CpanelUserInterface $users,
        PermissionInterface $permissions,
        GroupInterface $groups,
        UserFormInterface $userForm
    )
    {
        $this->users = $users;
        $this->permissions = $permissions;
        $this->groups = $groups;
        $this->userForm = $userForm;
    }

    /**
     * Show all the users
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->findAll();
        return View::make(Config::get('cpanel::views.users_index'))
            ->with('users',$users);
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
            return Redirect::route('cpanel.users.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display add user form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = $this->users->getEmptyUser();
        $genericPermissions = $this->permissions->mergePermissions(array(),Config::get('cpanel::generic_permission'));
        $modulePermissions = $this->permissions->mergePermissions(array());

        //Get Groups
        $groups = $this->groups->findAll();

        return View::make(Config::get('cpanel::views.users_create'))
            ->with('user',$user)
            ->with('genericPermissions',$genericPermissions)
            ->with('modulePermissions',$modulePermissions)
            ->with('groups',$groups);
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
            $user = $this->users->findById($id);
            $groups = $this->groups->findAll();

            //get only the group id the user belong to
            $userGroupsId = array_pluck($user->getGroups()->toArray(), 'id');

            $rules = Config::get('cpanel::generic_permission');

            $genericPermissions = $this->permissions->mergePermissions($user->getPermissions(),$rules);
            $modulePermissions = $this->permissions->mergePermissions($user->getPermissions());

            return View::make(Config::get('cpanel::views.users_edit'))
                ->with('user',$user)
                ->with('groups',$groups)
                ->with('userGroupsId',$userGroupsId)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions);
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
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
        $inputs = Input::except('groups', 'activate');
        $inputs['groups'] = Input::get('groups', array());
        $inputs['activate'] = Input::get('activate', false);

        if ( $this->userForm->create($inputs) )
        {
            return Redirect::route('cpanel.users.index')
                ->with('success', Lang::get('cpanel::users.create_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->userForm->getErrors());
    }

    /**
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        try
        {
            $credentials = Input::except('groups');
            $credentials['groups'] = Input::get('groups', array());
            $credentials['id'] = $id;


            if( $this->userForm->update($credentials) )
            {
                return Redirect::route('cpanel.users.index')
                    ->with('success', Lang::get('cpanel::users.update_success'));
            }

            return Redirect::back()
                ->withInput()
                ->withErrors($this->userForm->getErrors());
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                    ->with('error', $e->getMessage());
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
