<?php

namespace SeoStackWP\Admin;

/**
 * Class Render
 * @package SeoStackWP\Admin
 */
class Render {

	/**
	 * Render a view with the given settings.
	 *
	 * @param       $templateName
	 * @param array $vars
	 *
	 * @return mixed
	 */
	public function view( $templateName, $vars = array() ) {
		if ( !file_exists( dirname(SEOSTACK_PLUGIN_ROOT) . '/src/SeoStackWP/Admin/Views/' . $templateName . '.php' ) ) {
			return false;
		}

		ob_start();
		include_once( dirname(SEOSTACK_PLUGIN_ROOT) . '/src/SeoStackWP/Admin/Views/' . $templateName . '.php' );
		$page = ob_get_clean();

		return $page;
	}

	/**
	 * @return mixed
	 */
	public function redirectToSettingsFirst() {
		return wp_redirect( 'admin.php?page=seostack_settings_first' );
	}

	/**
	 * Show a success message!
	 *
	 * @param $message
	 *
	 * @return string
	 */
	public function buildSuccesMessage( $message ) {
		return '<div class="notice notice-success is-dismissible"><p><strong>Yay!</strong> ' . $message . '</p></div>';
	}

	/**
	 * Show an error message!
	 *
	 * @param $message
	 *
	 * @return string
	 */
	public function buildErrorMessage( $message ) {
		return '<div class="notice notice-error is-dismissible"><p><strong>Whoops!</strong> ' . $message . '</p></div>';
	}

}