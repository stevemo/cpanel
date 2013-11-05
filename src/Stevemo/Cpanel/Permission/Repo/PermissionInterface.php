<?php namespace Stevemo\Cpanel\Permission\Repo;

interface PermissionInterface {

    /**
     * Grab all the permissions from storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $columns
     *
     * @return \StdClass
     */
    public function all($columns = array('*'));

    /**
     * Put into storage a new permission
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $data
     *
     * @return \StdClass
     */
    public function create(array $data);

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
    public function update(array $data);

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
    public function delete($id);

} 