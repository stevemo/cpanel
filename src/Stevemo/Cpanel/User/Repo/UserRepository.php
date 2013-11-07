<?php namespace Stevemo\Cpanel\User\Repo;

use Cartalyst\Sentry\Sentry;

class UserRepository implements UserInterface {

    /**
     * @var \Cartalyst\Sentry\Sentry
     */
    protected  $sentry;

    /**
     * @param Sentry $sentry
     */
    public function __construct(Sentry $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * Attempts to authenticate the given user
     * according to the passed credentials.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $remember
     *
     * @return \StdClass
     */
    public function authenticate(array $credentials, $remember = false)
    {
        // TODO-Stevemo: Implement authenticate() method.
    }

    /**
     * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function check()
    {
        // TODO-Stevemo: Implement check() method.
    }

    /**
     * Delete the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function delete()
    {
        // TODO-Stevemo: Implement delete() method.
    }

    /**
     * Returns an all users.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function findAll()
    {
        return $this->sentry->findAllUsers();
    }

    /**
     * Finds a user by the given user ID.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \StdClass
     */
    public function findById($id)
    {
        // TODO-Stevemo: Implement findById() method.
    }

    /**
     * Logs the current user out.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function logout()
    {
        // TODO-Stevemo: Implement logout() method.
    }

    /**
     * Returns the current user being used by Sentry, if any.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return mixed
     */
    public function getUser()
    {
        // TODO-Stevemo: Implement getUser() method.
    }

    /**
     * Gets the user provider for Sentry.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Cartalyst\Sentry\Users\ProviderInterface
     */
    protected function getUserProvider()
    {
        return $this->sentry->getUserProvider();
    }

    /**
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param       $id
     * @param array $attributes
     *
     * @return bool
     */
    public function update($id, array $attributes)
    {
        // TODO-Stevemo: Implement update() method.
    }

    /**
     * Registers a user by giving the required credentials
     * and an optional flag for whether to activate the user.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $activate
     *
     * @return \StdClass
     */
    public function register(array $credentials, $activate = false)
    {
        // TODO-Stevemo: Implement register() method.
    }
}