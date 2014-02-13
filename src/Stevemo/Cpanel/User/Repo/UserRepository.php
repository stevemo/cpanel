<?php namespace Stevemo\Cpanel\User\Repo;

use Cartalyst\Sentry\Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException as SentryUserNotFoundException;
use Illuminate\Events\Dispatcher;
use Cartalyst\Sentry\Users\UserInterface;
use Cartalyst\Sentry\Users\UserAlreadyActivatedException;

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
     * Activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return bool
     */
    public function activate($id)
    {
        $user = $this->findById($id);

        try
        {
            if ( $user->attemptActivation($user->getActivationCode()) )
            {
                $this->event->fire('users.activate',array($user));
                return true;
            }
        }
        catch (UserAlreadyActivatedException $e){}


        return false;
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
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function authenticate(array $credentials, $remember = false)
    {
        $user = $this->sentry->authenticate($credentials,$remember);
        $this->event->fire('users.login',array($user));
        return $user;
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
     * De activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return bool
     */
    public function deactivate($id)
    {
        $user = $this->findById($id);
        $user->activated = 0;
        $user->activated_at = null;
        $user->save();
        $this->event->fire('users.deactivate',array($user));
        return true;
    }

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
    public function delete($id)
    {
        $user = $this->findById($id);
        $eventData = $user;
        $user->delete();
        $this->event->fire('users.delete', array($eventData));
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
     * Find a given user by the login attribute
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $login
     *
     * @throws UserNotFoundException
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function findByLogin($login)
    {
        try
        {
            return $this->sentry->findUserByLogin($login);
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
        $user = $this->sentry->getUser();
        $this->sentry->logout();
        $this->event->fire('users.logout',array($user));
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
        return $this->sentry->getUser();
    }

    /**
     * Get the throttle provider for a given user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @throws UserNotFoundException
     *
     * @return \Cartalyst\Sentry\Throttling\ThrottleInterface
     */
    public function getUserThrottle($id)
    {
        try
        {
            return $this->sentry->findThrottlerByUserId($id);
        }
        catch (SentryUserNotFoundException $e)
        {
            throw new UserNotFoundException($e->getMessage());
        }
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
     *  Reset a given user password
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $code
     * @param $password
     *
     * @throws UserNotFoundException
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function resetPassword($code,$password)
    {
        try
        {
            $user =  $this->sentry->findUserByResetPasswordCode($code);
            $user->password = $password;
            $user->save();

            $this->event->fire('users.password.reset',array($user));

            return $user;
        }
        catch (SentryUserNotFoundException $e)
        {
            throw new UserNotFoundException($e->getMessage());
        }
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

        if ( array_key_exists('groups',$attributes) )
        {
            $this->syncGroups($attributes['groups'], $user);
        }

        $this->event->fire('users.update',array($user));

        return $user;
    }

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
    public function updatePermissions($id, array $permissions)
    {
        $user = $this->findById($id);
        $user->permissions = $permissions;
        $user->save();
        $this->event->fire('users.permissions.update',array($user));
        return $user;
    }

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
    public function updateThrottleStatus($id, $status)
    {
        $throttle = $this->getUserThrottle($id);
        call_user_func(array($throttle,$status));
        $this->event->fire('users.' . $status, array($throttle));
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
        );

        if ( array_key_exists('permissions',$credentials) )
        {
            $cred['permissions'] = $credentials['permissions'];
        }

        $user = $this->sentry->register($cred,$activate);

        if ( array_key_exists('groups',$credentials) )
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