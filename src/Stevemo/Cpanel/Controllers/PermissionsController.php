<?php namespace Stevemo\Cpanel\Controllers;

use View;
use Redirect;
use Input;
use Lang;
use Event;
use Config;
use Stevemo\Cpanel\Provider\PermissionProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionsController extends BaseController {

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
     * @param  PermissionProvider $permissions
     */
    public function __construct(PermissionProvider $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Display all the permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function index()
    {
        $permissions = $this->permissions->all();
        $roles = $this->permissions->getRoles();
        return View::make(Config::get('cpanel::views.permissions_index') , compact('permissions','roles'));
    }

    /**
     * Display new permission form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *@return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $roles = $this->permissions->getRoles();
        return View::make( Config::get('cpanel::views.permissions_create'), compact('roles'));
    }

    /**
     * Display the edit permission form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return Response
     */
    public function edit($id)
    {
        try
        {
            $permission = $this->permissions->findOrFail($id);
            $roles = $this->permissions->getRoles();
            return View::make( Config::get('cpanel::views.permissions_edit'), compact('permission','roles'));
        }
        catch ( ModelNotFoundException $e )
        {
            return Redirect::route('admin.permissions.index')->with('error', Lang::get('admin::permission.model_not_found'));
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
        $validation = $this->getValidationService('permission');

        if( $validation->passes() )
        {
            $perm = $this->permissions->create($validation->getData());
            Event::fire('permissions.create', array($perm));
            return Redirect::route('admin.permissions.index')->with('success', Lang::get('cpanel::permissions.create_success'));
        }
        return Redirect::back()->withInput()->withErrors($validation->getErrors());

    }

    /**
     * Update permissions into the database
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        try
        {
            $data = Input::all();
            $data['id'] = $id;
            $validation = $this->getValidationService('permission',$data);

            if( $validation->passes() )
            {
                $perm = $this->permissions->update($id,$validation->getData());
                Event::fire('permissions.update', array($perm));
                return Redirect::route('admin.permissions.index')->with('success', Lang::get('cpanel::permissions.update_success'));
            }

            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        catch ( ModelNotFoundException $e )
        {
            return Redirect::route('admin.permissions.index')->with('error', Lang::get('cpanel::permissions.model_not_found'));
        }
    }

   /**
     * Delete a permission
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try
        {
            $eventData = $this->permissions->delete($id);
            Event::fire('permission.delete', array($eventData));
            return Redirect::route('admin.permissions.index')->with('success', Lang::get('cpanel::permissions.delete_success'));
        }
        catch ( ModelNotFoundException $e)
        {
            return Redirect::route('admin.permissions.index')->with('error', Lang::get('cpanel::permissions.model_not_found'));
        }
    }

}
