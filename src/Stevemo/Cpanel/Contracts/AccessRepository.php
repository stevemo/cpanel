<?php namespace Stevemo\Cpanel\Contracts;

interface AccessRepository {

	/**
	 * Find the Access by ID
	 *
	 * @author Steve Montambeault
	 *
	 * @param $id
	 *
	 * @return \Stevemo\Cpanel\Contracts\AccessInterface
	 *
	 * @throws RoleNotFoundException
	 */
	public function findById($id);

	/**
	 * Find all Access lists
	 *
	 * @author Steve Montambeault
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function findAll();

	/**
	 * Create a new Access list
	 *
	 * @author   Steve Montambeault
	 *
	 * @param string $name
	 * @param array  $rules
	 *
	 * @return RoleInterface
	 */
	public function create($name, array $rules);
} 