<?php namespace Stevemo\Cpanel;


use Illuminate\Support\ServiceProvider;

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
		$this->registerRoutes();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['cpanel'];
	}

	/**
	 * Register Package Routes
	 *
	 * @author Steve Montambeault
	 *
	 */
	private function registerRoutes()
	{
		$route = $this->app['router'];
		$config = [
			'namespace' => 'Stevemo\Cpanel\Http\Controllers',
			'prefix' => $this->app['config']->get('cpanel::prefix','admin')
		];

		$this->RegistrationRoutes($route, $config);
	}

	/**
	 * Registration routes
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @param \Illuminate\Routing\Router $router
	 * @param array $config
	 *
	 */
	private function RegistrationRoutes($router, $config)
	{
		$router->group($config, function($router)
		{
			$router->get('register', [
				'as'   => 'cpanel.register',
				'uses' => 'RegistrationController@create',
			]);

			$router->post('register', [
				'as'   => 'cpanel.register',
				'uses' => 'RegistrationController@store',
			]);
		});
	}

}
