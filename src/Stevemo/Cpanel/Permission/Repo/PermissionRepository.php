<?php  namespace Stevemo\Cpanel\Permission\Repo;

use Illuminate\Events\Dispatcher;
use Illuminate\Config\Repository;
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
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @param Permission                    $model
     * @param Dispatcher                    $event
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Permission $model, Dispatcher $event, Repository $config)
    {
        $this->event = $event;
        $this->model = $model;
        $this->config = $config;
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
     * Get the generic permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function generic()
    {
        return $this->config->get('cpanel::generic_permission',array());
    }

    /**
     * get the module permissions
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function module()
    {
        return $this->model->all(array('name','permissions'))->toArray();
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