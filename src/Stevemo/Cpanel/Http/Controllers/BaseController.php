<?php namespace Stevemo\Cpanel\Http\Controllers;

use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Stevemo\Cpanel\Traits\FlashTrait;
use Config, View, Lang, Redirect;

class BaseController extends Controller {
	use FlashTrait, CommanderTrait;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Create the view
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @param $view
	 * @param array $data
	 * @return \Illuminate\View\View
	 */
	protected function view($view, array $data = [])
	{
		return View::make($view, $data);
	}

	/**
	 *
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectBack()
	{
		return Redirect::back();
	}

	/**
	 *
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @param $error
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectBackWithError($error)
	{
		return Redirect::back()->withInput()->withErrors($error);
	}

	/**
	 *
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectBackWithInput()
	{
		return Redirect::back()->withInput();
	}

	/**
	 *
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @param $route
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function redirectRoute($route)
	{
		return Redirect::route($route);
	}

	/**
	 * Get the translation for the given key.
	 *
	 * @param string $key
	 * @param array $replace
	 * @param string $locale
	 * @return string
	 */
	protected function translate($key, array $replace = [], $locale = null)
	{
		return Lang::get($key, $replace, $locale);
	}

	/**
	 * Execute the command
	 *
	 * @author Steve Montambeault <http://stevemo.ca>
	 *
	 * @param $commandKey
	 * @return mixed
	 */
	protected function executeCommand($commandKey)
	{
		$command = Config::get("cpanel::commands.{$commandKey}");
		return $this->execute($command);
	}

} 