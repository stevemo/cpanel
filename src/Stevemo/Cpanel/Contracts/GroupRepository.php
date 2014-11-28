<?php namespace Stevemo\Cpanel\Contracts;

interface GroupRepository {

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 *
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 *
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findById($id);

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 *
	 * @return \Cartalyst\Sentry\Groups\GroupInterface  $group
	 *
	 * @throws \Cartalyst\Sentry\Groups\GroupNotFoundException
	 */
	public function findByName($name);

	/**
	 * Returns all groups.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function findAll();

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 *
	 * @return \Cartalyst\Sentry\Groups\GroupInterface
	 */
	public function create(array $attributes);
} 