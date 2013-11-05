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
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cpanel');
	}

}
