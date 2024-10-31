<?php

namespace SeoStackWP\Api;

/**
 * Class TagDocument
 * @package SeoStackWP\Api
 */
class TagDocument implements DocumentStructureInterface {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}
}