<?php

namespace SeoStackWP\Api;

/**
 * Class AuthorDocument
 * @package SeoStackWP\Api
 */
class AuthorDocument implements DocumentStructureInterface {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $lastName;

	/**
	 * @var string
	 */
	public $gravatar;

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
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName( $lastName ) {
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getGravatar() {
		return $this->gravatar;
	}

	/**
	 * @param string $gravatar
	 */
	public function setGravatar( $gravatar ) {
		$this->gravatar = $gravatar;
	}

}