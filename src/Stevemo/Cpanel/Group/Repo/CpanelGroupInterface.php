<?php namespace Stevemo\Cpanel\Group\Repo;

interface CpanelGroupInterface {

    /**
     * Find the group by ID.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int  $id
     * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
     *
     * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
     */
    public function findById($id);

    /**
     * Find the group by name.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  string  $name
     * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
     *
     * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
     */
    public function findByName($name);

    /**
     * Returns all groups.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array  $groups
     */
    public function findAll();

    /**
     * Creates a group.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array  $attributes
     *
     * @return \Cartalyst\Sentry\Groups\GroupInterface
     */
    public function create(array $attributes);

    /**
     * Update a group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function update(array $attributes);

    /**
     * Delete a group
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return void
     *
     * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
     */
    public function delete($id);

} 