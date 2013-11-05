<?php  namespace Stevemo\Cpanel\Permission\Repo;

use Illuminate\Events\Dispatcher;

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
     * @return bool
     */
    public function create(array $data)
    {
        // TODO-Stevemo: Implement create() method.
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
        // TODO-Stevemo: Implement update() method.
    }

    /**
     * Delete a permission from storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        // TODO-Stevemo: Implement delete() method.
    }
}