<?php namespace Stevemo\Cpanel\Contracts;

interface AccessManager {

	/**
	 * Find the Access by ID
	 *
	 * @author Steve Montambeault
	 *
	 * @param $id
	 *
	 * @return \Stevemo\Cpanel\Contracts\AccessInterface
	 *
	 * @throws \Stevemo\Cpanel\Exceptions\AccessNotFoundException
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
	 * @return \Stevemo\Cpanel\Contracts\AccessInterface
	 */
	public function create($name, array $rules);
} 