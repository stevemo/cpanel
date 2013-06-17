<?php namespace Stevemo\Cpanel\Controllers;

use Stevemo\Cpanel\Provider\PermissionProvider;
use View;
use Redirect;
use Input;
use Lang;
use Sentry;
use Event;
use Config;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class GroupsPermissionsController extends BaseController {


    /**
     * @var PermissionProvider
     */
    protected $permissions;

    /**
     * [__construct description]
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  GroupRepository $groups
     * @param  PermissionProvider $permissions
     */
    public function __construct(PermissionProvider $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Display the group permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $grouID
     * @return Response
     */
    public function index($groupId)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($groupId);

            // Get the group permissions
            $groupPermissions = $group->getPermissions();

            $permissions = $this->permissions->all(array('name','permissions'));

            $modulePerm = $this->permissions->getMergePermissions($groupPermissions, $permissions->toArray());

            $roles = array(array('name' => 'generic', 'permissions' => array('view','create','update','delete')));

            $genericPerm = $this->permissions->getMergePermissions($groupPermissions, $roles);

            return View::make(Config::get('cpanel::views.groups_permission'), compact('modulePerm','group','genericPerm'));
        }
        catch ( GroupNotFoundException $e)
        {
            return Redirect::route('admin.groups.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the group permissions.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $groupId
     * @return Response
     */
    public function update($groupId)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($groupId);
            $group->permissions = Input::get('rules');
            $group->save();
            Event::fire('groups.permissions.update', array($group));
            return Redirect::route('admin.groups.index')->with('success', Lang::get('cpanel::groups.update_success') );
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
    }
}
