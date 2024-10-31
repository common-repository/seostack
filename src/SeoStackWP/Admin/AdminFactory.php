<?php

namespace SeoStackWP\Admin;

use SeoStackWP\Admin\Controllers\DashboardController;
use SeoStackWP\Admin\Controllers\SettingsController;
use SeoStackWP\Datasource\WordPressDatasource;

/**
 * Class AdminFactory
 * @package SeoStackWP\Admin
 */
class AdminFactory {

	/**
	 * @var SettingsController
	 */
	private $settingsController;
	/**
	 * @var DashboardController
	 */
	private $dashboardController;
	/**
	 * @var WordPressDatasource
	 */
	private $datasource;

	/**
	 * AdminFactory constructor.
	 *
	 * @param DashboardController $dashboardController
	 * @param SettingsController  $settingsController
	 * @param WordPressDatasource $datasource
	 */
	public function __construct( $dashboardController, $settingsController, WordPressDatasource $datasource ) {
		$this->settingsController  = $settingsController;
		$this->dashboardController = $dashboardController;
		$this->datasource          = $datasource;

		if ( $this->datasource->isInstallationCompleted() === false ) {
			$this->showInstallationMessage();
		}
	}

	/**
	 * Hook the menu items
	 */
	public function hookMenuPage() {
		$apiKey = $this->datasource->getApiKey();

		add_menu_page(
			'SEOStack',
			__( 'SEOStack', 'seostack' ),
			'manage_options',
			'seostack_dashboard',
			array(
				$this,
				'showPage',
			),
			plugins_url( '../../images/icon_16.png', plugin_dir_path( __FILE__ ) ),
			81.19378439
		);
		add_submenu_page( 'seostack_dashboard', __( 'Dashboard', 'seostack' ), __( 'Dashboard', 'seostack' ), 'manage_options', 'seostack_dashboard', array( $this, 'showPage' ) );

		if ( empty( $apiKey ) || $this->datasource->isInstallationCompleted() === false ) {
			add_submenu_page( 'seostack_dashboard', __( 'Setup now', 'seostack' ), '<span style="color: #ffa238;">' . __( 'Setup now', 'seostack' ) . '</span>', 'manage_options', 'seostack_settings_first', array( $this, 'showPage' ) );
		} else {
			add_submenu_page( 'seostack_dashboard', __( 'Live search', 'seostack' ), __( 'Live search', 'seostack' ), 'manage_options', 'seostack_live_search', array( $this, 'showPage' ) );
			add_submenu_page( 'seostack_dashboard', __( 'Settings', 'seostack' ), __( 'Settings', 'seostack' ), 'manage_options', 'seostack_settings', array( $this, 'showPage' ) );
			add_submenu_page( 'seostack_dashboard', __( 'Upgrade now', 'seostack' ), '<span style="color: #ffa238;">' . __( 'Upgrade now', 'seostack' ) . '</span>', 'manage_options', 'seostack_settings', array( $this, 'showPage' ) );
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'seostackAddJsColorPicker' ) );
	}

	/**
	 * Seostack add JS color picker.
	 */
	public function seostackAddJsColorPicker() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'custom-script-handle', plugins_url( 'js/seostack.admin.js', SEOSTACK_PLUGIN_ROOT ), array( 'wp-color-picker' ), false, true );
	}

	/**
	 * Render the requested page
	 */
	public function showPage() {
		switch ( filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ) ) {
			case 'seostack_dashboard':
				$this->dashboardController->dashboardAction();
				break;
			case 'seostack_live_search':
				$this->settingsController->liveSearchAction();
				break;
			case 'seostack_settings':
				$this->settingsController->settingsAction();
				break;
			case 'seostack_settings_first':
				$this->settingsController->settingsFirstAction();
				break;
		}
	}

	/**
	 * Seostack installation notice.
	 */
	public function seostackInstallationNotice() {
		echo '<div class="notice notice-warning">';
		echo '<p><strong>' . __( 'Warning' ) . ':</strong> ';
		echo sprintf(
				__( 'The seostack plugin is activated, but not yet installed on your website. %sStart the installation%s', 'seostack' ),
				'<a href="admin.php?page=seostack_settings_first" class="button">',
				'</a>'
			) . '</p>';
		echo '</div>';
	}

	/**
	 * Call the add action to hook the admin notice
	 */
	private function showInstallationMessage() {
		if ( isset( $_GET['page'] ) && $_GET['page'] === 'seostack_settings_first' ) {
			return;
		}

		add_action( 'admin_notices', array( $this, 'seostackInstallationNotice' ) );
	}

}