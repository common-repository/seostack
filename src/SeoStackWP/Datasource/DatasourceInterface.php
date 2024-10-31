<?php

namespace SeoStackWP\Datasource;

/**
 * Interface DatasourceInterface
 * @package SeoStackWP\Datasource
 */
interface DatasourceInterface {

	/**
	 * @param        $name
	 * @param string $defaultValue
	 *
	 * @return mixed
	 */
	public function getSetting( $name, $defaultValue = '' );

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	public function setSetting( $name, $value );

	/**
	 * @return mixed
	 */
	public function getApiKey();

	/**
	 * @return bool
	 */
	public function isInstallationCompleted();

	/**
	 * @return array
	 */
	public function getLiveSearchSettings();
}