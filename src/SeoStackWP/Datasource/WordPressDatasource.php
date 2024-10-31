<?php

namespace SeoStackWP\Datasource;

/**
 * Class WordPressDatasource
 * @package SeoStackWP\Datasource
 */
class WordPressDatasource implements DatasourceInterface {

	const WP_OPTION_NAME = 'seostack_';

	/**
	 * Get a setting from the WordPress configured database.
	 *
	 * @param $name
	 * @param $defaultValue
	 *
	 * @return mixed
	 */
	public function getSetting( $name, $defaultValue = '' ) {
		return get_option( self::WP_OPTION_NAME . $name, $defaultValue );
	}

	/**
	 * Update a setting in the WordPress configured database.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	public function setSetting( $name, $value ) {
		return update_option( self::WP_OPTION_NAME . $name, $value );
	}

	/**
	 * Get the API key for this website.
	 *
	 * @return mixed
	 */
	public function getApiKey() {
		return $this->getSetting( 'api_key', '' );
	}

	/**
	 * Get the status from the first time installation
	 *
	 * @return bool
	 */
	public function isInstallationCompleted() {
		return $this->getSetting( 'install_completed', false );
	}

	/**
	 * Get the live search design settings
	 *
	 * @return mixed
	 */
	public function getLiveSearchSettings() {
		return $this->getSetting( 'live_search', array(
			'bg_color'         => '#fff',
			'border_color'     => '#ccc',
			'border_size'      => 1,
			'link_color'       => '#000',
			'link_color_hover' => '#000',
		) );
	}

}