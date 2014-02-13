<?php namespace Stevemo\Cpanel\Controllers;

use View, Redirect, Input, Lang, Config;
use Stevemo\Cpanel\Group\Repo\CpanelGroupInterface;
use Stevemo\Cpanel\Group\Form\GroupFormInterface;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\Group\Repo\GroupNotFoundException;

class GroupsController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface
     */
    protected $groups;

    /**
     * @var \Stevemo\Cpanel\Group\Form\GroupFormInterface
     */
    protected $form;

    /**
     * @var \Stevemo\Cpanel\Permission\Repo\PermissionInterface
     */
    protected $permissions;

    /**
     * @param \Stevemo\Cpanel\Group\Repo\CpanelGroupInterface     $groups
     * @param \Stevemo\Cpanel\Group\Form\GroupFormInterface       $form
     * @param \Stevemo\Cpanel\Permission\Repo\PermissionInterface $permissions
     */
    public function __construct(
        CpanelGroupInterface $groups,
        GroupFormInterface $form,
        PermissionInterface $permissions
    )
    {
        $this->groups = $groups;
        $this->form = $form;
        $this->permissions = $permissions;
    }


    /**
     * Display all the groups
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groups = $this->groups->findAll();
        return View::make(Config::get('cpanel::views.groups_index'), compact('groups'));
    }

    /**
     * Display create a new group form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $genericPermissions = $this->permissions->generic();
        $modulePermissions = $this->permissions->module();
        $groupPermissions = array();

        return View::make(Config::get('cpanel::views.groups_create'))
            ->with('genericPermissions',$genericPermissions)
            ->with('modulePermissions',$modulePermissions)
            ->with('groupPermissions',$groupPermissions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try
        {
            $group = $this->groups->findById($id);

            $groupPermissions = $group->getPermissions();
            $genericPermissions = $this->permissions->generic();
            $modulePermissions = $this->permissions->module();


            return View::make(Config::get('cpanel::views.groups_edit'))
                ->with('group',$group)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions)
                ->with('groupPermissions',$groupPermissions);
        }
        catch ( GroupNotFoundException $e)
        {
            return Redirect::route('admin.groups.index')->with('error', $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        if ( $this->form->create(Input::all()) )
        {
            return Redirect::route('cpanel.groups.index')
                ->with('success', Lang::get('cpanel::groups.create_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->form->getErrors());
    }

    /**
     * Update the specified resource in storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        try
        {
            $inputs = Input::all();
            $inputs['id'] = $id;

            if ( $this->form->update($inputs) )
            {
                return Redirect::route('cpanel.groups.index')
                    ->with('success', Lang::get('cpanel::groups.update_success') );
            }

            return Redirect::back()
                ->withInput()
                ->withErrors($this->form->getErrors());
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::route('cpanel.groups.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try
        {
            $this->groups->delete($id);

            return Redirect::route('cpanel.groups.index')
                ->with('success', Lang::get('cpanel::groups.delete_success'));
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

}
