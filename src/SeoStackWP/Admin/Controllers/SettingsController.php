<?php

namespace SeoStackWP\Admin\Controllers;

use SeoStackWP\Admin\Render;
use SeoStackWP\Api\ApiService;
use SeoStackWP\Datasource\WordPressDatasource;

/**
 * Class SettingsController
 * @package SeoStackWP\Admin\Controllers
 */
class SettingsController {

	/**
	 * @var WordPressDatasource
	 */
	private $datasource;

	/**
	 * @var Render
	 */
	private $render;

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @var ApiService
	 */
	private $apiService;

	/**
	 * SettingsController constructor.
	 *
	 * @param Render              $render
	 * @param ApiService          $apiService
	 * @param WordPressDatasource $datasource
	 */
	public function __construct( Render $render, ApiService $apiService, WordPressDatasource $datasource ) {
		$this->render     = $render;
		$this->datasource = $datasource;
		$this->apiService = $apiService;
	}

	/**
	 * Render the admin settings page.
	 */
	public function settingsAction() {
		if ( $this->datasource->getApiKey() === '' ) {
			wp_safe_redirect( 'admin.php?seostack_settings_first' );

			return;
		}

		if ( isset( $_GET['reindex'] ) ) {
			return $this->settingsReIndexAction();
		}

		$vars                 = array();
		$vars['api_key']      = $this->datasource->getSetting( 'api_key', '' );
		$vars['email']        = $this->datasource->getSetting( 'email', '' );
		$vars['api_key_info'] = $this->apiService->getApiKeyInfo();
		$vars['title']        = __( 'Manage settings', 'seostack' );

		echo $this->render->view( 'settings', $vars );

		return;
	}

	/**
	 * Render the admin settings page.
	 */
	public function settingsFirstAction() {
		$vars = array();

		$currentSetup = filter_input( INPUT_GET, 'step' );

		if ( $currentSetup === 'second' ) {
			return $this->buildSettingsSecond();
		} elseif ( $currentSetup === 'third' ) {
			return $this->buildSettingsThird();
		}

		return $this->buildSettingsFirst();
	}

	/**
	 * Render the live search settings page and manage the frontend colors.
	 */
	public function liveSearchAction() {
		if ( $this->datasource->getApiKey() === '' ) {
			wp_safe_redirect( 'admin.php?seostack_settings_first' );

			return;
		}

		$vars                = array();
		$vars['live_search'] = $this->datasource->getLiveSearchSettings();
		$vars['title']       = __( 'Manage live search settings', 'seostack' );

		if ( isset( $_POST['seostack'] ) && wp_verify_nonce( $_POST['seostack_settings_nonce'], 'seostack_settings' ) ) {
			$vars['live_search']['bg_color']         = sanitize_hex_color( $_POST['seostack']['live_search']['bg_color'] );
			$vars['live_search']['border_color']     = sanitize_hex_color( $_POST['seostack']['live_search']['border_color'] );
			$vars['live_search']['border_size']      = (int) $_POST['seostack']['live_search']['border_size'];
			$vars['live_search']['link_color']       = sanitize_hex_color( $_POST['seostack']['live_search']['link_color'] );
			$vars['live_search']['link_color_hover'] = sanitize_hex_color( $_POST['seostack']['live_search']['link_color_hover'] );

			$this->datasource->setSetting( 'live_search', $vars['live_search'] );
		}

		echo $this->render->view( 'settings_live_search', $vars );

		return;
	}

	/**
	 * Render the first step in setting up the plugin.
	 *
	 * @return mixed
	 */
	private function buildSettingsFirst() {
		$vars                    = array();
		$vars['api_key']         = $this->datasource->getSetting( 'api_key', '' );
		$vars['email']           = $this->datasource->getSetting( 'email', 'email' );
		$vars['api_key_info']    = $this->apiService->getApiKeyInfo();
		$vars['total_posts']     = $this->apiService->getPublishedPostsCount();
		$vars['email_webmaster'] = get_option( 'admin_email' );
		$vars['title']           = __( 'SEOStack one time setup', 'seostack' );

		echo $this->render->view( 'settings_first', $vars );

		return;
	}

	/**
	 * Buidl the second step for settings.
	 *
	 * @return mixed
	 */
	private function buildSettingsSecond() {
		if ( isset( $_POST['seostack'] ) ) {
			$email  = $_POST['seostack']['email'];
			$domain = parse_url( get_site_url(), PHP_URL_HOST );

			$this->datasource->setSetting( 'email', sanitize_email( $email ) );

			if ( isset( $_POST['seostack']['newsletter'] ) ) {
				$newsletter = 1;
			} else {
				$newsletter = 0;
			}

			$url      = SEOSTACK_API_ENDPOINT . 'api/domains/register?domain=' . $domain . '&email=' . $email . '&newsletter=' . $newsletter;
			$response = wp_remote_post( $url, array(
					'method'      => 'POST',
					'timeout'     => 10,
					'redirection' => 3,
					'httpversion' => '1.0',
					'blocking'    => true,
					'headers'     => array(),
					'body'        => array(),
					'cookies'     => array()
				)
			);

			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();

				$vars['message'] = $this->render->buildErrorMessage( sprintf( __( 'Something went wrong: %s', 'seostack' ), $error_message ) );
			} else {
				$apiResult = json_decode( $response['body'] );

				if ( !empty( $apiResult->api_key ) ) {
					$this->datasource->setSetting( 'api_key', sanitize_key( $apiResult->api_key ) );
				}

				$vars['message'] = $this->render->buildSuccesMessage( __( 'The API key was saved successfully. Please continue below!', 'seostack' ) );
			}
		}

		$vars['api_key']         = $this->datasource->getSetting( 'api_key' );
		$vars['email']           = $this->datasource->getSetting( 'email' );
		$vars['api_key_info']    = $this->apiService->getApiKeyInfo();
		$vars['email_webmaster'] = get_option( 'admin_email' );
		$vars['title']           = __( 'SEOStack one time setup - Step 2', 'seostack' );

		$vars['total_posts'] = $this->apiService->getPublishedPostsCount();
		$vars['api_limit']   = $vars['api_key_info']->doc_limit;

		if ( $this->apiService->isCompletelyIndexable( $vars['api_limit'], $vars['total_posts'] ) ) {
			echo $this->render->view( 'settings_second', $vars );
		} else {
			echo $this->render->view( 'settings_second_not_indexable', $vars );
		}

		return;
	}


	/**
	 * Render the first step in setting up the plugin.
	 *
	 * @return mixed
	 */
	private function buildSettingsThird() {
		$this->datasource->setSetting( 'install_completed', true );

		$vars            = array();
		$vars['api_key'] = $this->datasource->getSetting( 'api_key', '' );
		$vars['title']   = __( 'SEOStack one time setup - Completed!', 'seostack' );
		$vars['message'] = (string) $this->render->buildSuccesMessage( __( 'The installation was completed successfully.', 'seostack' ) );

		echo $this->render->view( 'settings_third', $vars );

		return;
	}

	/**
	 * @return mixed
	 */
	private function settingsReIndexAction() {
		$vars                 = array();
		$vars['api_key']      = $this->apiService->getApiKey();
		$vars['api_key_info'] = $this->apiService->getApiKeyInfo();
		$vars['title']        = __( 'SEOStack Reindex', 'seostack' );
		$vars['total_posts']  = $this->apiService->getPublishedPostsCount();
		$vars['api_limit']    = $vars['api_key_info']->doc_limit;


		if ( $this->apiService->isCompletelyIndexable( $vars['api_limit'], $vars['total_posts'] ) ) {
			echo $this->render->view( 'settings_reindex', $vars );
		} else {
			echo $this->render->view( 'settings_reindex_not_indexable', $vars );
		}

		return;
	}
}