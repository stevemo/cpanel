<?php namespace Stevemo\Cpanel\Traits;

use App;

trait DispatchableTrait {

	/**
	 * Dispatch all events for an entity.
	 *
	 * @param string $event
	 * @param array  $payload
	 *
	 * @return array|null
	 */
	public function dispatchEvent($event, $payload = [])
	{
		return $this->getDispatcher()->fire($event, $payload);
	}

	/**
	 * Get the event dispatcher.
	 *
	 * @return \Illuminate\Events\Dispatcher
	 */
	public function getDispatcher()
	{
		return App::make('events');
	}
} 