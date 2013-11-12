<?php namespace Stevemo\Cpanel\User\Repo;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException as SentryUserNotFoundException;
use Illuminate\Events\Dispatcher;
use Cartalyst\Sentry\Users\UserInterface;

class UserRepository implements CpanelUserInterface {

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
    public function create(array $credentials, $activate = false)
    {
        $user = $this->storeUser($credentials,$activate);
        $this->event->fire('users.create',array($user));

        return $user;
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
     * @throws UserNotFoundException
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function findById($id)
    {
        try
        {
            return $this->sentry->findUserById($id);
        }
        catch (SentryUserNotFoundException $e)
        {
            throw new UserNotFoundException($e->getMessage());
        }
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
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function update($id, array $attributes)
    {
        $user = $this->findById($id);

        $user->first_name = $attributes['first_name'];
        $user->last_name = $attributes['last_name'];
        $user->email = $attributes['email'];
        $user->permissions = $attributes['permissions'];

        if( array_key_exists('password', $attributes) )
        {
            $user->password = $attributes['password'];
        }

        $user->save();

        if ( array_key_exists('groups',$attributes['groups']) )
        {
            $this->syncGroups($attributes['groups'], $user);
        }

        $this->event->fire('users.update',array($user));

        return $user;
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
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function register(array $credentials, $activate = false)
    {
        $user = $this->storeUser($credentials,$activate);
        $this->event->fire('users.register',array($user));

        return $user;
    }

    /**
     * Create user into storage
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array $credentials
     * @param bool  $activate
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    protected function storeUser(array $credentials, $activate = false)
    {
        $cred = array(
            'first_name'  => $credentials['first_name'],
            'last_name'   => $credentials['last_name'],
            'email'       => $credentials['email'],
            'password'    => $credentials['password'],
            'permissions' => $credentials['permissions']
        );

        $user = $this->sentry->register($cred,$activate);

        if ( array_key_exists('groups',$credentials['groups']) )
        {
            $this->syncGroups($credentials['groups'], $user);
        }

        return $user;
    }

    /**
     * Add groups to a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param array                                 $groups
     * @param \Cartalyst\Sentry\Users\UserInterface $user
     */
    protected function syncGroups(array $groups, UserInterface $user)
    {
        $user->groups()->detach();
        $user->groups()->sync($groups);
    }
}