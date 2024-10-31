<?php

namespace SeoStackWP\Frontend;

use SeoStackWP\Datasource\WordPressDatasource;

/**
 * Class FrontendFactory
 * @package SeoStackWP\Frontend
 */
class FrontendFactory {

	/**
	 * @var FrontendService
	 */
	private $frontendService;

	/**
	 * AdminFactory constructor.
	 *
	 * @param FrontendService $frontendService
	 *
	 * @internal param WordPressDatasource $datasource
	 */
	public function __construct( FrontendService $frontendService ) {
		$this->frontendService = $frontendService;
	}

	/**
	 * Init the frontend
	 */
	public function init() {
		add_action( 'wp_head', array( $this, 'seostackFrontendHead' ) );
		add_action( 'wp_footer', array( $this, 'seostackFrontendFooter' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'seostackFrontendScripts' ) );
	}

	/**
	 * Hook some data in the WordPress frontend of this website.
	 *
	 * @return string
	 */
	public function seostackFrontendHead() {
		$head = '<!-- seostack.io | SeoStack for WordPress version ' . SEOSTACK_VERSION . ' | https://wordpress.org/plugins/seostack -->' . PHP_EOL;
		$head .= "<link rel='dns-prefetch' href='//search.api.seostack.io'>" . PHP_EOL;
		$head .= $this->frontendService->getCss() . PHP_EOL;
		$head .= '<!-- / seostack.io -->' . PHP_EOL;

		echo $head;
	}

	/**
	 * Hook some data in the WordPress frontend of this website.
	 *
	 * @return string
	 */
	public function seostackFrontendFooter() {
		$head = '<script type="text/javascript">var seostack_domain = "' . str_replace( array( 'https://', 'http://' ), '', get_site_url() ) . '";</script>';

		echo $head;
	}

	/**
	 * Frontend scripts
	 */
	public function seostackFrontendScripts() {
		wp_enqueue_script(
			'seostack-js',
			plugin_dir_url( SEOSTACK_PLUGIN_ROOT ) . 'js/seostack.frontend.js',
			false,
			SEOSTACK_VERSION,
			true
		);

		wp_enqueue_style(
			'seostack-css',
			plugin_dir_url( SEOSTACK_PLUGIN_ROOT ) . 'css/seostack.frontend.css'
		);
	}

}