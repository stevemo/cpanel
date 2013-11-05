<?php namespace Stevemo\Cpanel\Group\Repo;

use Cartalyst\Sentry\Sentry;

class GroupRepository implements GroupInterface {

    /**
     * @var \Cartalyst\Sentry\Sentry
     */
    protected $sentry;

    /**
     * @param Sentry $sentry
     */
    public function __construct(Sentry $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * Find the group by ID.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     *
     * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
     *
     * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
     */
    public function findById($id)
    {
        return $this->sentry->getGroupProvider()->findById($id);
    }

    /**
     * Find the group by name.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  string $name
     *
     * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
     *
     * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
     */
    public function findByName($name)
    {
        return $this->sentry->getGroupProvider()->findByName($name);
    }

    /**
     * Returns all groups.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array  $groups
     */
    public function findAll()
    {
        return $this->sentry->getGroupProvider()->findAll();
    }

    /**
     * Creates a group.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  array $attributes
     *
     * @return \Cartalyst\Sentry\Groups\GroupInterface
     */
    public function create(array $attributes)
    {
        return $this->sentry->getGroupProvider()->create($attributes);
    }
}