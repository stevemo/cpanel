<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Redirect, Lang, Input;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Form\UserFormInterface;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\Group\Repo\CpanelGroupInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;

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
     * @var \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface
     */
    protected $groups;

    /**
     * @var \Stevemo\Cpanel\User\Form\UserFormInterface
     */
    protected $userForm;

    /**
     * @param \Stevemo\Cpanel\User\Repo\CpanelUserInterface       $users
     * @param \Stevemo\Cpanel\Permission\Repo\PermissionInterface $permissions
     * @param \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface     $groups
     * @param \Stevemo\Cpanel\User\Form\UserFormInterface         $userForm
     */
    public function __construct(
        CpanelUserInterface $users,
        PermissionInterface $permissions,
        CpanelGroupInterface $groups,
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
            $throttle = $this->users->getUserThrottle($id);
            $user = $throttle->getUser();
            $permissions = $user->getMergedPermissions();

            return View::make(Config::get('cpanel::views.users_show'))
                ->with('user',$user)
                ->with('groups',$user->getGroups())
                ->with('permissions',$permissions)
                ->with('throttle',$throttle);
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

        $userPermissions = array();
        $genericPermissions = $this->permissions->generic();
        $modulePermissions = $this->permissions->module();


        //Get Groups
        $groups = $this->groups->findAll();

        return View::make(Config::get('cpanel::views.users_create'))
            ->with('user',$user)
            ->with('userPermissions',$userPermissions)
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

            $userPermissions = $user->getPermissions();
            $genericPermissions = $this->permissions->generic();
            $modulePermissions = $this->permissions->module();

            //get only the group id the user belong to
            $userGroupsId = array_pluck($user->getGroups()->toArray(), 'id');

            return View::make(Config::get('cpanel::views.users_edit'))
                ->with('user',$user)
                ->with('groups',$groups)
                ->with('userGroupsId',$userGroupsId)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions)
                ->with('userPermissions',$userPermissions);
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
        $currentUser = $this->users->getUser();

        if ($currentUser->id === (int) $id)
        {
            return Redirect::back()
                ->with('error', Lang::get('cpanel::users.delete_denied') );
        }

        try
        {
            $this->users->delete($id);
            return Redirect::route('cpanel.users.index')
                ->with('success',Lang::get('cpanel::users.delete_success'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

    /**
     * deactivate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putDeactivate($id)
    {
        try
        {
            $this->users->deactivate($id);
            return Redirect::route('cpanel.users.index')
                ->with('success',Lang::get('cpanel::users.deactivation_success'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

    /**
     * Activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putActivate($id)
    {
        try
        {
            if ($this->users->activate($id))
            {
                // User activation passed
                return Redirect::route('cpanel.users.index')
                    ->with('success',Lang::get('cpanel::users.activation_success'));
            }
            else
            {
                // User activation failed
                return Redirect::route('cpanel.users.index')
                    ->with('error',Lang::get('cpanel::users.activation_fail'));
            }
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

}
