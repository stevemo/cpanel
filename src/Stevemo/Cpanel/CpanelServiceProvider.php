<?php namespace Stevemo\Cpanel;

use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;
use Stevemo\Cpanel\Console\InstallCommand;
use Stevemo\Cpanel\Console\UserSeedCommand;
use Stevemo\Cpanel\Permission\Repo\PermissionRepository;
use Stevemo\Cpanel\Permission\Repo\Permission;
use Stevemo\Cpanel\Permission\Form\PermissionForm;
use Stevemo\Cpanel\Permission\Form\PermissionValidator;
use Stevemo\Cpanel\Group\Repo\GroupRepository;
use Stevemo\Cpanel\Group\Form\GroupForm;
use Stevemo\Cpanel\Group\Form\GroupValidator;
use Stevemo\Cpanel\User\Repo\UserRepository;
use Stevemo\Cpanel\User\Form\UserForm;
use Stevemo\Cpanel\User\Form\UserValidator;
use Stevemo\Cpanel\User\Form\PasswordForm;
use Stevemo\Cpanel\User\Form\PasswordValidator;
use Stevemo\Cpanel\User\UserMailer;

class CpanelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('stevemo/cpanel');
        include __DIR__ .'/routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCommands();
        $this->registerPermission();
        $this->registerGroup();
        $this->registerUser();
        $this->registerPassword();
	}

     /**
     * Register console commands cpanel:install
     * Register console commands cpanel:user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function registerCommands()
    {
        $this->app['command.cpanel.install'] = $this->app->share(function()
        {
            return new InstallCommand();
        });

        $this->app['command.cpanel.user'] = $this->app->share(function()
        {
            return new UserSeedCommand();
        });

        $this->commands('command.cpanel.install','command.cpanel.user');
    }

    /**
     * Register Permission module component
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function registerPermission()
    {
        $app = $this->app;

        $app->bind('Stevemo\Cpanel\Permission\Repo\PermissionInterface', function($app)
        {
            return new PermissionRepository(new Permission, $app['events'], $app['config']);
        });

        $app->bind('Stevemo\Cpanel\Permission\Form\PermissionFormInterface', function($app)
        {
            return new PermissionForm(
                new PermissionValidator($app['validator'], new MessageBag),
                $app->make('Stevemo\Cpanel\Permission\Repo\PermissionInterface')
            );
        });
    }

    /**
     * Register Group binding
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function registerGroup()
    {
        $app = $this->app;

        $app->bind('Stevemo\Cpanel\Group\Repo\CpanelGroupInterface', function($app)
        {
            return new GroupRepository($app['sentry'], $app['events']);
        });

        $app->bind('Stevemo\Cpanel\Group\Form\GroupFormInterface', function($app)
        {
            return new GroupForm(
                new GroupValidator($app['validator'], new MessageBag),
                $app->make('Stevemo\Cpanel\Group\Repo\CpanelGroupInterface')
            );
        });
    }

    /**
     * Register User binding
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function registerUser()
    {
        $app = $this->app;

        $app->bind('Stevemo\Cpanel\User\Repo\CpanelUserInterface', function($app)
        {
            return new UserRepository($app['sentry'], $app['events']);
        });

        $app->bind('Stevemo\Cpanel\User\Form\UserFormInterface', function($app)
        {
            return new UserForm(
                new UserValidator($app['validator'], new MessageBag),
                $app->make('Stevemo\Cpanel\User\Repo\CpanelUserInterface')
            );
        });
    }

    /**
     * Register bindings for the password reset
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     */
    public function registerPassword()
    {
        $app = $this->app;

        $app->bind('Stevemo\Cpanel\User\Form\PasswordFormInterface', function($app)
        {
           return new PasswordForm(
               new PasswordValidator($app['validator'], new MessageBag),
               $app->make('Stevemo\Cpanel\User\Repo\CpanelUserInterface'),
               $app->make('Stevemo\Cpanel\User\UserMailerInterface')
           );
        });

        $app->bind('Stevemo\Cpanel\User\UserMailerInterface', function($app)
        {
            return new UserMailer();
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cpanel');
	}

}
