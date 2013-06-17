<?php namespace Stevemo\Cpanel;

use Illuminate\Support\ServiceProvider;
use Stevemo\Cpanel\Console\InstallCommand;
use Stevemo\Cpanel\Console\UserSeedCommand;

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
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		include __DIR__ .'/routes.php';
        $this->registerInstallCommands();
        $this->registerUserSeedCommands();
        $this->commands('command.cpanel.install','command.cpanel.user');
	}

        /**
     * Register console commands cpanel:install
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function registerInstallCommands()
    {
        $this->app['command.cpanel.install'] = $this->app->share(function($app)
        {
            return new InstallCommand();
        });
    }

    /**
     * Register console commands cpanel:user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return void
     */
    public function registerUserSeedCommands()
    {
        $this->app['command.cpanel.user'] = $this->app->share(function($app)
        {
            return new UserSeedCommand();
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
