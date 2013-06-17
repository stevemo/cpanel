<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Redirect;
use Input;
use Lang;
use Event;
use Sentry;
use Config;
use Stevemo\Cpanel\Provider\PermissionProvider;
use Cartalyst\Sentry\Users\UserNotFoundException;

class UsersPermissionsController extends BaseController {


    /**
     * @var PermissionProvider
     */
    protected $permissions;

    public function __construct( PermissionProvider $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Display the user permissins
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $userId
     * @return Response
     */
    public function index($userId)
    {
        try
        {
            $user       = Sentry::getUserProvider()->findById($userId);
            $modulePerm = $this->permissions->getMergePermissions($user->getPermissions());

            $roles = array(array('name' => 'generic', 'permissions' => array('view','create','update','delete')));
            $genericPerm = $this->permissions->getMergePermissions($user->getPermissions(), $roles);

            return View::make(Config::get('cpanel::views.users_permission'),compact('user','modulePerm','genericPerm'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('admin.users.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update user permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $userId
     * @return Response
     */
    public function update($userId)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($userId);

            $user->permissions = Input::get('rules', array());
            $user->save();

            Event::fire('users.permissions.update', array($user));

            return Redirect::route('admin.users.index')->with('success', Lang::get('cpanel::users.permissions_update_success'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('admin.users.permissions')->with('error', $e->getMessage());
        }

    }

}
