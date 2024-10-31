<?php

namespace SeoStackWP\Admin\Controllers;

use SeoStackWP\Admin\Render;
use SeoStackWP\Api\ApiService;

/**
 * Class DashboardController
 * @package SeoStackWP\Admin\Controllers
 */
class DashboardController {

	/**
	 * @var Render
	 */
	private $render;

	/**
	 * @var ApiService
	 */
	private $apiService;

	/**
	 * SettingsController constructor.
	 *
	 * @param Render     $render
	 * @param ApiService $apiService
	 */
	public function __construct( Render $render, ApiService $apiService ) {
		$this->render     = $render;
		$this->apiService = $apiService;
	}

	/**
	 * Render the dashboard interface for the user.
	 */
	public function dashboardAction() {
		$vars     = array();
		$api_info = $this->apiService->getApiKeyInfo();

		$vars['api_key']                = $this->apiService->getApiKey();
		$vars['installation_completed'] = $this->apiService->isInstallationCompleted();
		$vars['total_posts']            = $this->apiService->getPublishedPostsCount();
		$vars['api_key_info']           = $api_info;
		$vars['title']                  = __( 'Dashboard' );

		if ( $vars['installation_completed'] === false ) {
			echo $this->render->view( 'dashboard_installation', $vars );
			return;
		}

		echo $this->render->view( 'dashboard', $vars );
		return;
	}
}