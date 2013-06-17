<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Redirect;
use Input;
use Lang;
use Sentry;
use Event;
use Config;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class GroupsController extends BaseController {


    /**
     * Display all the groups
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function index()
    {
        $groups = Sentry::getGroupProvider()->findAll();
        return View::make(Config::get('cpanel::views.groups_index'), compact('groups'));
    }

    /**
     * Display create a new group form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
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
     * @return Response
     */
    public function store()
    {
        try
        {
            $group = Sentry::getGroupProvider()->create(Input::only('name'));
            Event::fire('groups.create', array($group));
            return Redirect::route('admin.groups.index')->with('success', Lang::get('cpanel::groups.create_success'));
        }
        catch (NameRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
        catch (GroupExistsException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
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
