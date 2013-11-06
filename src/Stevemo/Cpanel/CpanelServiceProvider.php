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
            return new PermissionRepository(new Permission, $app['events']);
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

        $app->bind('Stevemo\Cpanel\Group\Repo\GroupInterface', function($app)
        {
            return new GroupRepository($app['sentry'], $app['events']);
        });

        $app->bind('Stevemo\Cpanel\Group\Form\GroupFormInterface', function($app)
        {
            return new GroupForm(
                new GroupValidator($app['validator'], new MessageBag),
                $app->make('Stevemo\Cpanel\Group\Repo\GroupInterface')
            );
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
