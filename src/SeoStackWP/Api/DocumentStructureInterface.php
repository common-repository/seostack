<?php

namespace SeoStackWP\Api;

/**
 * Interface DocumentStructureInterface
 * @package SeoStackWP\Api
 */
interface DocumentStructureInterface {

	/**
	 * @return mixed
	 */
	public function getName();

	/**
	 * @param string $name
	 */
	public function setName( $name );

}