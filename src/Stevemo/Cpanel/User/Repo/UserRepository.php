<?php namespace Stevemo\Cpanel\User\Repo;

use Cartalyst\Sentry\Sentry;
use Illuminate\Events\Dispatcher;

class UserRepository implements UserInterface {

    /**
     * @var \Cartalyst\Sentry\Sentry
     */
    protected  $sentry;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $event;

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
     * Returns an empty user object.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \StdClass
     */
    public function getEmptyUser()
    {
        return $this->sentry->getEmptyUser();
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
        $cred = array(
            'first_name'  => $credentials['first_name'],
            'last_name'   => $credentials['last_name'],
            'email'       => $credentials['email'],
            'password'    => $credentials['password'],
            'permissions' => $credentials['permissions']
        );

        $user = $this->sentry->register($cred,$activate);

        //attach groups
        $user->groups()->sync($credentials['groups']);

        $this->event->fire('users.create',array($user));

        return $user;
    }
}