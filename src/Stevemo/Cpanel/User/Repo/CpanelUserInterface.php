<?php namespace Stevemo\Cpanel\User\Repo;

interface CpanelUserInterface {

    /**
     * Activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return bool
     */
    public function activate($id);

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
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function authenticate(array $credentials, $remember = false);

    /**
     * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return bool
     */
    public function check();

    /**
     * Create a new user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $activate
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function create(array $credentials, $activate = false);

    /**
     * De activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return bool
     */
    public function deactivate($id);

    /**
     * Delete the user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int $id
     *
     * @return void
     */
    public function delete($id);

    /**
     * Returns an all users.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return array
     */
    public function findAll();

    /**
     * Finds a user by the given user ID.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function findById($id);

    /**
     * Find a given user by the login attribute
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $login
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function findByLogin($login);

    /**
     * Logs the current user out.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function logout();

    /**
     * Returns an empty user object.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \StdClass
     */
    public function getEmptyUser();

    /**
     * Returns the current user being used by Sentry, if any.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return mixed|\Cartalyst\Sentry\Users\UserInterface
     */
    public function getUser();

    /**
     * Get the throttle provider for a given user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Cartalyst\Sentry\Throttling\ThrottleInterface
     */
    public function getUserThrottle($id);

    /**
     *  Reset a given user password
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $code
     * @param $password
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function resetPassword($code,$password);

    /**
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param       $id
     * @param array $attributes
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function update($id, array $attributes);

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
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function register(array $credentials, $activate = false);

    /**
     * Update permissions for a given user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int   $id
     * @param array $permissions
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function updatePermissions($id, array $permissions);

    /**
     *
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     * @param $status
     *
     * @throws \BadMethodCallException
     *
     * @return void
     */
    public function updateThrottleStatus($id, $status);

} 