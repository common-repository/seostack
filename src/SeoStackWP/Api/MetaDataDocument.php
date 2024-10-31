<?php

namespace SeoStackWP\Api;

/**
 * Class MetaDataDocument
 * @package SeoStackWP\Api
 */
class MetaDataDocument implements DocumentStructureInterface {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $value;

	/**
	 * @return string
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

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue( $value ) {
		$this->value = $value;
	}

}