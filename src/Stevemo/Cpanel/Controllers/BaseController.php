<?php namespace Stevemo\Cpanel\Controllers;

use Illuminate\Routing\Controller;
use Laracasts\Commander\CommanderTrait;
use Stevemo\Cpanel\Traits\FlashTrait;
use Config;

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
	 * Grab the command name from the config file
	 *
	 * @author Steve Montambeault
	 *
	 * @param $name
	 *
	 * @return string
	 */
	public function getCommand($name)
	{
		return Config::get("cpanel::commands.{$name}");
	}
} 