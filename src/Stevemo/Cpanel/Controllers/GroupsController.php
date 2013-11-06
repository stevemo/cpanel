<?php namespace Stevemo\Cpanel\Controllers;

use View, Redirect, Input, Lang, Config;
use Stevemo\Cpanel\Group\Repo\GroupInterface;
use Stevemo\Cpanel\Group\Form\GroupFormInterface;


class GroupsController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\Group\Repo\GroupInterface
     */
    protected $groups;

    /**
     * @var \Stevemo\Cpanel\Group\Form\GroupFormInterface
     */
    protected $form;

    /**
     * @param GroupInterface                                $groups
     * @param \Stevemo\Cpanel\Group\Form\GroupFormInterface $form
     */
    public function __construct(GroupInterface $groups, GroupFormInterface $form)
    {
        $this->groups = $groups;
        $this->form = $form;
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
        return View::make(Config::get('cpanel::views.groups_create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function edit($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            return View::make(Config::get('cpanel::views.groups_edit'),compact('group'));
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
     * @return Response
     */
    public function update($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $group->name = Input::get('name');
            $group->save();
            Event::fire('groups.update', array($group));
            return Redirect::route('admin.groups.index')->with('success', Lang::get('cpanel::groups.update_success') );
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
        catch (GroupExistsException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function destroy($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $eventData = $group;
            $group->delete();
            Event::fire('groups.delete', array($eventData));
            return Redirect::route('admin.groups.index')->with('success', Lang::get('cpanel::groups.delete_success'));
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

}
