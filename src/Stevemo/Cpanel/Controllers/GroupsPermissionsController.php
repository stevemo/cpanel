<?php namespace Stevemo\Cpanel\Controllers;

use View, Redirect, Input, Lang, Config;
use Stevemo\Cpanel\Group\Repo\GroupInterface;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\Group\Repo\GroupNotFoundException;

class GroupsPermissionsController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\Permission\Repo\PermissionInterface
     */
    protected $permissions;

    /**
     * @var \Stevemo\Cpanel\Group\Repo\GroupInterface
     */
    protected $groups;


    /**
     * [__construct description]
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param \Stevemo\Cpanel\Permission\Repo\PermissionInterface $permissions
     * @param \Stevemo\Cpanel\Group\Repo\GroupInterface           $groups
     */
    public function __construct(PermissionInterface $permissions, GroupInterface $groups)
    {
        $this->permissions = $permissions;
        $this->groups = $groups;
    }

    /**
     * Display the group permissions
     *
     * @author   Steve Montambeault
     * @link     http://stevemo.ca
     *
     * @param $groupId
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($groupId)
    {
        try
        {
            $group = $this->groups->findById($groupId);
            $groupPermissions = $group->getPermissions();

            $roles = array(
                array(
                    'name' => 'generic',
                    'permissions' => array('view','create','update','delete')
                )
            );

            $genericPermissions = $this->permissions->mergePermissions($groupPermissions,$roles);
            $modulePermissions = $this->permissions->mergePermissions($groupPermissions);

            return View::make(Config::get('cpanel::views.groups_permission'))
                ->with('group',$group)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions);

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
