<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Redirect, Lang, Input;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Repo\UserNotFoundException;

class UsersPermissionsController extends BaseController {


    /**
     * @var \Stevemo\Cpanel\Permission\Repo\PermissionInterface
     */
    private $permissions;

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    private $users;

    /**
     * @param \Stevemo\Cpanel\Permission\Repo\PermissionInterface $permissions
     * @param \Stevemo\Cpanel\User\Repo\CpanelUserInterface       $users
     */
    public function __construct(PermissionInterface $permissions, CpanelUserInterface $users)
    {
        $this->permissions = $permissions;
        $this->users = $users;
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
            $user = $this->users->findById($userId);
            $userPermissions = $user->getPermissions();
            $genericPermissions = $this->permissions->generic();
            $modulePermissions = $this->permissions->module();

            return View::make(Config::get('cpanel::views.users_permission'))
                ->with('user',$user)
                ->with('userPermissions',$userPermissions)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions);
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error', $e->getMessage());
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
            $permissions = Input::get('permissions', array());
            $this->users->updatePermissions($userId,$permissions);

            return Redirect::route('cpanel.users.index')
                ->with('success', Lang::get('cpanel::users.permissions_update_success'));
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.permissions')
                ->with('error', $e->getMessage());
        }

    }

}
