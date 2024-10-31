<?php

namespace SeoStackWP\Api;

/**
 * Class CategoryDocument
 * @package SeoStackWP\Api
 */
class CategoryDocument implements DocumentStructureInterface {

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