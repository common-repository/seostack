<?php

namespace SeoStackWP\Events;

use SeoStackWP\Admin\AdminFactory;
use SeoStackWP\Frontend\FrontendFactory;

/**
 * Class EventService
 * @package SeoStackWP\Events
 */
class EventService {

	/**
	 * @var AdminFactory
	 */
	private $adminFactory;

	/**
	 * @var FrontendFactory
	 */
	private $frontendFactory;

	/**
	 * EventsService constructor.
	 *
	 * @param AdminFactory    $adminFactory
	 * @param FrontendFactory $frontendFactory
	 */
	public function __construct( $adminFactory, $frontendFactory ) {
		$this->adminFactory    = $adminFactory;
		$this->frontendFactory = $frontendFactory;
	}

	/**
	 * Init the SeoStack plugin, run the hooks from here.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this->adminFactory, 'hookMenuPage' ) );

		if( !is_admin() ) {
			$this->frontendFactory->init();
		}
	}


}