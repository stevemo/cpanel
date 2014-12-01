<?php namespace Stevemo\Cpanel;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\UserInterface;
use Stevemo\Cpanel\Contracts\AuthManager;

class Auth implements AuthManager {

	/**
	 * @type \Cartalyst\Sentry\Sentry
	 */
	private $provider;

	/**
	 * @param \Cartalyst\Sentry\Sentry $provider
	 */
	function __construct(Sentry $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * Attempts to authenticate the given user
	 * according to the passed credentials.
	 *
	 * @author Steve Montambeault
	 *
	 * @param  array $credentials
	 * @param  bool  $remember
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 *
	 * @throws \Cartalyst\Sentry\Throttling\UserBannedException
	 * @throws \Cartalyst\Sentry\Throttling\UserSuspendedException
	 * @throws \Cartalyst\Sentry\Users\LoginRequiredException
	 * @throws \Cartalyst\Sentry\Users\PasswordRequiredException
	 * @throws \Cartalyst\Sentry\Users\UserNotFoundException
	 */
	public function authenticate(array $credentials, $remember = false)
	{
		return $this->provider->authenticate($credentials, $remember);
	}

	/**
	 * Check to see if the user is logged in and activated, and has not been banned or suspended.
	 *
	 * @author Steve Montambeault
	 *
	 * @return bool
	 */
	public function check()
	{
		return $this->provider->check();
	}

	/**
	 * Logs in the given user and sets properties
	 * in the session.
	 *
	 * @author Steve Montambeault
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface $user
	 * @param  bool                                  $remember
	 *
	 * @return void
	 * @throws \Cartalyst\Sentry\Users\UserNotActivatedException
	 */
	public function login(UserInterface $user, $remember = false)
	{
		$this->provider->login($user, $remember);
	}

	/**
	 * Logs the current user out.
	 *
	 * @author Steve Montambeault
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->provider->logout();
	}

	/**
	 * Registers a user by giving the required credentials
	 * and an optional flag for whether to activate the user.
	 *
	 * @author Steve Montambeault
	 *
	 * @param  array $credentials
	 * @param  bool  $activate
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function register(array $credentials, $activate = false)
	{
		return $this->provider->register($credentials, $activate);
	}

	/**
	 * Returns the current user being used by Sentry, if any.
	 *
	 * @author Steve Montambeault
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface
	 */
	public function user()
	{
		return $this->provider->getUser();
	}

	/**
	 * See if a user has access to the passed permission(s).
	 * Permissions are merged from all groups the user belongs to
	 * and then are checked against the passed permission(s).
	 *
	 * If multiple permissions are passed, the user must
	 * have access to all permissions passed through, unless the
	 * "all" flag is set to false.
	 *
	 * Super users have access no matter what.
	 *
	 * @param  string|array $permissions
	 * @param  bool         $all
	 *
	 * @return bool
	 */
	public function hasAccess($permissions, $all = true)
	{
		$user = $this->user();

		if (isset($user))
		{
			return $user->hasAccess($permissions, $all);
		}

		throw new \BadMethodCallException("No User has been set on the AuthManager to use hasAccess method.");
	}

}