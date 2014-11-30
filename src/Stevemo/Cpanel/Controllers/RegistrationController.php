<?php namespace Stevemo\Cpanel\Controllers;

use View;

class RegistrationController extends BaseController {

	/**
	 * Display the registration form
	 *
	 * @author Steve Montambeault
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return View::make('cpanel::registration.create');
	}

	public function store()
	{
		$this->execute($this->getCommand('register'));
	}
} 