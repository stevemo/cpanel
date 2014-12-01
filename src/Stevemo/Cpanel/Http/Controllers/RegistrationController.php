<?php namespace Stevemo\Cpanel\Http\Controllers;

use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use Laracasts\Validation\FormValidationException;

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
		return $this->view('cpanel::registration.create');
	}

	/**
	 * Register a new Member
	 *
	 * @author Steve Montambeault
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		try
		{
			$this->executeCommand('register');

			return $this->view('cpanel::registration.success');
		}
		catch (FormValidationException $e)
		{
			return $this->redirectBackWithError($e->getErrors());
		}
		catch (LoginRequiredException $e)
		{
			return $this->redirectBackWithError($e->getMessage());
		}
		catch (PasswordRequiredException $e)
		{
			return $this->redirectBackWithError($e->getMessage());
		}
		catch (UserExistsException $e)
		{
			return $this->redirectBackWithError($e->getMessage());
		}
	}

	/**
	 * Display the account activation page
	 *
	 * @author Steve Montambeault
	 *
	 * @param $code
	 *
	 * @return \Illuminate\View\View
	 */
	public function edit($code)
	{
		return $this->view('cpanel::registration.edit', compact('code'));
	}

	public function update($token)
	{

	}
} 