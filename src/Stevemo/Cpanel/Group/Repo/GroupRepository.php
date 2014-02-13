<?php namespace Stevemo\Cpanel\Group\Repo;

use Cartalyst\Sentry\Groups\GroupNotFoundException as SentryGroupNotFoundException;
use Cartalyst\Sentry\Sentry;
use Illuminate\Events\Dispatcher;

class GroupRepository implements CpanelGroupInterface {

    /**
     * @var \Cartalyst\Sentry\Sentry
     */
    protected $sentry;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected  $event;

    /**
     * @param Sentry                        $sentry
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function __construct(Sentry $sentry, Dispatcher $event)
    {
        $this->sentry = $sentry;
        $this->event = $event;
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
     * @throws GroupNotFoundException
     */
    public function findById($id)
    {
        try
        {
            return $this->sentry->getGroupProvider()->findById($id);
        }
        catch (SentryGroupNotFoundException $e)
        {
            throw new GroupNotFoundException($e->getMessage());
        }
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
     * @throws GroupNotFoundException
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
        $group = $this->sentry->getGroupProvider()->create($attributes);
        $this->event->fire('groups.create', array($group));
        return $group;
    }

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
    public function update(array $attributes)
    {
        $group = $this->findById($attributes['id']);
        $group->name = $attributes['name'];
        $group->permissions = $attributes['permissions'];
        $group->save();
        $this->event->fire('groups.update',array($group));
        return true;
    }

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
    public function delete($id)
    {
        $group = $this->findById($id);
        $old = $group;
        $group->delete();
        $this->event->fire('groups.delete', array($old));
    }

}