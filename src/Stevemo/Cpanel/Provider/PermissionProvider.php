<?php namespace Stevemo\Cpanel\Provider;

use Stevemo\Cpanel\Models\Permission;

class PermissionProvider {


    /**
     * Model use by the repository
     * @var model
     */
    protected $model;

    
    /**
     * [__construct description]
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  Permission $permission 
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * prep roles for FORMER
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @return array 
     */
    public function getRoles()
    {
        return array('inputs' => array(
            'view'   => array( 'name' => 'permissions[view]', 'value' => 'view', 'id' => ''),
            'create' => array( 'name' => 'permissions[create]', 'value' => 'create', 'id' => '' ),
            'update' => array( 'name' => 'permissions[update]', 'value' => 'update', 'id' => ''),
            'delete' => array( 'name' => 'permissions[delete]', 'value' => 'delete', 'id' => '' ),
        ));
    }

    /**
     * Get all of the models from the database.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = array('*'))
    {
        return $this->model->newQuery()->get($columns);
    }

    /**
     * Save model to the database
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  array $inputs 
     * @return Illuminate\Database\Eloquent\Model Permission
     */
    public function create(array $inputs)
    {
        $model = $this->model->newInstance($inputs);
        $model->save();
        return $model;
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = array('*'))
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    /**
     * Update model
     *  
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *  
     * @param  int $id 
     * @param  array $inputs 
     * @return [Illuminate\Database\Eloquent\Model Permission
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, array $inputs)
    {
        $model = $this->findOrFail($id);
        $model->fill($inputs);
        $model->save();
        return $model;
    }

    /**
     * Merge group permission with database permission
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $groupPermissions
     * @param  array $permissions
     * @return array
     */
    public function getMergePermissions(array $groupPermissions, array $permissions = array())
    {
        if ( count($permissions) < 1 )
        {
            $permissions = $this->all(array('name','permissions'))->toArray();
        }
        
        foreach ($permissions as $primary_key => $perm)
        {
            $id = 1;
            foreach ($perm['permissions'] as $key =>$rules )
            {
                $permissions[$primary_key]['permissions'][$key] = array(
                    'name'  => "rules[$rules]",
                    'text'  => $rules,
                    'value' => array_key_exists( $rules, $groupPermissions ) ? $groupPermissions[$rules] : '0',
                    'id'    => 'input_' . $perm['name'] . $id
                );
                $id++;
            }

        }

        return $permissions;
    }

    /**
     * Delete the permission model
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return array
     */
    public function delete($id)
    {
        $model = $this->findOrFail($id);
        $data = array(
            'name' => $model->name,
            'permissions' => $model->permissions
        );
        $model->delete();
        return $data;
    }
}