<?php namespace Stevemo\Cpanel\Registration;

use Laracasts\Commander\CommandHandler;
use Stevemo\Cpanel\Contracts\AuthManager;
use Stevemo\Cpanel\Traits\DispatchableTrait;

class RegisterMemberCommandHandler implements CommandHandler {
	use DispatchableTrait;

	/**
	 * @type \Stevemo\Cpanel\Contracts\AuthManager
	 */
	private $auth;

	/**
	 * @param \Stevemo\Cpanel\Contracts\AuthManager $auth
	 */
	function __construct(AuthManager $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Register a new Member
	 *
	 * @param \Stevemo\Cpanel\Registration\RegisterMemberCommand $command
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface|mixed
	 */
	public function handle($command)
	{
		$member = $this->auth->register($command->toArray(), false);

		$this->dispatchEvent('Cpanel.MemberHasRegistered', [$member]);

		return $member;
	}
}