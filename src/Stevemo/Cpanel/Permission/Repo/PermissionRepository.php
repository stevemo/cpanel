<?php  namespace Stevemo\Cpanel\Permission\Repo;

use Illuminate\Events\Dispatcher;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionRepository implements PermissionInterface {

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected  $event;

    /**
     * @var Permission
     */
    protected  $model;

    /**
     * @param Permission $model
     * @param Dispatcher $event
     */
    public function __construct(Permission $model, Dispatcher $event)
    {
        $this->event = $event;
        $this->model = $model;
    }

    /**
     * Grab all the permissions from storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|\StdClass|static[]
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    /**
     * Put into storage a new permission
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return bool|\Illuminate\Database\Eloquent\Model|\StdClass|static
     */
    public function create(array $data)
    {
        $perm = $this->model->create(array(
            'name'        => $data['name'],
            'permissions' => $data['permissions']
        ));

        if ( ! $perm )
        {
            return false;
        }
        else
        {
            $this->event->fire('permissions.create', array($perm));
            return $perm;
        }
    }

    /**
     * Delete a permission from storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        try
        {
            $perm = $this->model->findOrFail($id);
            $oldData = $perm;
            $perm->delete();
            $this->event->fire('permissions.delete', array($oldData));

            return true;
        }
        catch ( ModelNotFoundException $e)
        {
            return false;
        }
    }

    /**
     * Get a Permission model by it's primary key
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param       $id
     * @param array $columns
     *
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|\StdClass|static
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id,$columns);
    }

    /**
     *
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param       $id
     * @param array $columns
     *
     * @throws PermissionNotFoundException
     *
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        try
        {
            return $this->model->findOrFail($id,$columns);
        }
        catch ( ModelNotFoundException $e )
        {
            throw new PermissionNotFoundException;
        }
    }

    /**
     * Merge group permission with database permission
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $groupPermissions
     * @param array $merge
     *
     * @return array
     */
    public function mergePermissions(array $groupPermissions, array $merge = array())
    {
        if ( count($merge) == 0 )
        {
            $merge = $this->all(array('name','permissions'))->toArray();
        }

        foreach ($merge as $pk => $rules)
        {
            $id = 1;
            foreach ($rules['permissions'] as $title => $rule)
            {
                $merge[$pk]['permissions'][$title] = array(
                    'name' => "permissions[$rule]",
                    'text' => $rule,
                    'value' => array_key_exists($rule, $groupPermissions) ? $groupPermissions[$rule] : 0,
                    'id' => 'input' . $rules['name'] . $id,
                );
                $id++;
            }
        }

        return $merge;
    }

    /**
     * Update a permission into storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return bool
     */
    public function update(array $data)
    {
        $perm = $this->findOrFail($data['id']);

        $perm->name = $data['name'];
        $perm->permissions = $data['permissions'];
        $perm->save();

        $this->event->fire('permissions.update',array($perm));

        return true;
    }
}