<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Redirect;
use Input;
use Lang;
use Sentry;
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
        return View::make('cpanel::groups.index', compact('groups'));
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
        return View::make('cpanel::groups.create');
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

}