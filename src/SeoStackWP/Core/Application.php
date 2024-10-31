<?php

namespace SeoStackWP\Core;

use SeoStackWP\Events\EventService;

/**
 * Class Application
 * @package SeoStackWP\Core
 */
class Application {

	/**
	 * @var array Container array for the services
	 */
	protected $services = array();

	/**
	 * Register a new service in the framework.
	 *
	 * @param $serviceName
	 * @param $serviceClass
	 */
	public function register( $serviceName, $serviceClass ) {
		$this->services[$serviceName] = $serviceClass;
	}

	/**
	 * Get an already registered service.
	 *
	 * @param $serviceName
	 *
	 * @return mixed
	 */
	public function getService( $serviceName ) {
		return $this->services[$serviceName];
	}

	/**
	 * Initiate the application
	 */
	public function init() {
		/** @var EventService $eventService */
		$eventService = $this->getService('eventService');
		$eventService->init();
	}

}
