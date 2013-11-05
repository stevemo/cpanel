<?php namespace Stevemo\Cpanel\Controllers;

use View, Redirect, Input, Lang, Config;
use Stevemo\Cpanel\Permission\Repo\PermissionInterface;
use Stevemo\Cpanel\Permission\Repo\PermissionNotFoundException;
use Stevemo\Cpanel\Permission\Form\PermissionFormInterface;

class PermissionsController extends BaseController {

    /**
     * @var PermissionInterface
     */
    protected $permissions;

    /**
     * @var \Stevemo\Cpanel\Permission\Form\PermissionFormInterface
     */
    protected $form;

    /**
     * @param PermissionInterface     $permissions
     * @param PermissionFormInterface $form
     */
    public function __construct(PermissionInterface $permissions, PermissionFormInterface $form)
    {
        $this->permissions = $permissions;
        $this->form = $form;
    }

    /**
     * Display all the permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $permissions = $this->permissions->all();

        return View::make(Config::get('cpanel::views.permissions_index'))
            ->with('permissions', $permissions);
    }

    /**
     * Display new permission form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make( Config::get('cpanel::views.permissions_create'));
    }

    /**
     * Display the edit permission form
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
        $permission = $this->permissions->find($id);

        if ( $permission )
        {
            return View::make( Config::get('cpanel::views.permissions_edit') )
                ->with('permission', $permission);
        }
        else
        {
            return Redirect::route('cpanel.permissions.index')
                ->with('error', Lang::get('cpanel::permissions.model_not_found'));
        }
    }

    /**
     * Save new permissions into the database
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $inputs = Input::all();

        if ( $this->form->create($inputs) )
        {
            return Redirect::route('cpanel.permissions.index')
                ->with('success', Lang::get('cpanel::permissions.create_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->form->getErrors());
    }

    /**
     * Process the edit form
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
        $inputs = Input::all();
        $inputs['id'] = $id;

        try
        {
            if ( $this->form->update($inputs) )
            {
                return Redirect::route('cpanel.permissions.index')
                    ->with('success', Lang::get('cpanel::permissions.update_success'));
            }

            return Redirect::back()
                ->withInput()
                ->withErrors($this->form->getErrors());
        }
        catch ( PermissionNotFoundException $e )
        {
            return Redirect::route('cpanel.permissions.index')
                ->with('error', Lang::get('cpanel::permissions.model_not_found'));
        }
    }

    /**
     * Delete a permission module
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
        if ( $this->permissions->delete($id) )
        {
            return Redirect::route('cpanel.permissions.index')
                ->with('success', Lang::get('cpanel::permissions.delete_success'));
        }
        else
        {
            return Redirect::route('cpanel.permissions.index')
                ->with('error', Lang::get('cpanel::permissions.model_not_found'));
        }
    }

}
