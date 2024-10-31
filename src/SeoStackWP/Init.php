<?php

namespace SeoStackWP;

use SeoStackWP\Admin\AdminFactory;
use SeoStackWP\Admin\Controllers\AjaxController;
use SeoStackWP\Admin\Controllers\DashboardController;
use SeoStackWP\Admin\Controllers\SettingsController;
use SeoStackWP\Admin\Render;
use SeoStackWP\Api\ApiService;
use SeoStackWP\Core\Application;
use SeoStackWP\Datasource\WordPressDatasource;
use SeoStackWP\Events\EventService;
use SeoStackWP\Frontend\FrontendFactory;
use SeoStackWP\Frontend\FrontendService;

/**
 * Class Init
 * @package SeoStackWP
 */
class Init {

	/**
	 * Start the plugin
	 */
	public function init() {
		$application = new Application();

		$application->register( 'render', new Render() );

		/** Datasource */
		$application->register( 'wordPressDatasource', new WordPressDatasource() );

		$application->register( 'apiService', new ApiService(
			$application->getService( 'wordPressDatasource' )
		) );

		/** Controllers */
		$application->register( 'dashboardController', new DashboardController(
			$application->getService( 'render' ),
			$application->getService( 'apiService' )
		) );

		$application->register( 'settingsController', new SettingsController(
			$application->getService( 'render' ),
			$application->getService( 'apiService' ),
			$application->getService( 'wordPressDatasource' )
		) );

		$application->register( 'ajaxController', new AjaxController(
			$application->getService( 'apiService' )
		) );

		/** Factories */
		$application->register( 'adminFactory', new AdminFactory(
			$application->getService( 'dashboardController' ),
			$application->getService( 'settingsController' ),
			$application->getService( 'wordPressDatasource' )
		) );

		$application->register( 'frontendService', new FrontendService(
			$application->getService( 'wordPressDatasource' )
		) );

		/** Factories */
		$application->register( 'frontendFactory', new FrontendFactory(
			$application->getService( 'frontendService' )
		) );

		/** Services */
		$application->register( 'eventService', new EventService(
			$application->getService( 'adminFactory' ),
			$application->getService( 'frontendFactory' )
		) );

		add_action( 'wp_ajax_nopriv_seostack_index', array( $application->getService( 'ajaxController' ), 'batchIndexAction' ) );
		add_action( 'wp_ajax_seostack_index', array( $application->getService( 'ajaxController' ), 'batchIndexAction' ) );
		add_action( 'save_post', array( $application->getService( 'ajaxController' ), 'upsertPostAction' ) );
		add_action( 'trash_post', array( $application->getService( 'ajaxController' ), 'deletePostAction' ) );
		add_action( 'wp_trash_post', array( $application->getService( 'ajaxController' ), 'deletePostAction' ) );
		add_action( 'delete_post', array( $application->getService( 'ajaxController' ), 'deletePostAction' ) );

		$application->init();
	}

	/**
	 * Load the translation files for SEOStack
	 */
	public function loadPluginTranslations() {
		load_plugin_textdomain( 'seostack', false, basename( SEOSTACK_PLUGIN_ROOT_DIR ) . '/languages' );
	}

}