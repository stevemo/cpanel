<?php namespace Stevemo\Cpanel\Traits;

use App;

trait FlashTrait {

	/**
	 * @param $message
	 */
	public function flashSuccess($message)
	{
		$this->flashMessage($message, 'success');
	}

	/**
	 * @param $message
	 */
	public function flashInfo($message)
	{
		$this->flashMessage($message, 'info');
	}

	/**
	 * @param $message
	 */
	public function flashError($message)
	{
		$this->flashMessage($message, 'danger');
	}

	/**
	 * @param $message
	 */
	public function flashWarning($message)
	{
		$this->flashMessage($message, 'warning');
	}

	/**
	 *
	 *
	 * @author Steve Montambeault
	 *
	 * @param string $message
	 * @param string $level
	 * @param string $title
	 *
	 * @return void
	 */
	public function flashMessage($message, $level = 'info', $title = 'Notice')
	{
		App::make('flash')->message($message, $level, $title);
	}

} 