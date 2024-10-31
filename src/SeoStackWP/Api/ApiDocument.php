<?php

namespace SeoStackWP\Api;

/**
 * Class ApiDocument
 * @package SeoStackWP\Api
 */
class ApiDocument {

	/**
	 * @var string
	 */
	public $postStatus;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $content;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var CategoryDocument[]
	 */
	public $categories = array();

	/**
	 * @var TagDocument[]
	 */
	public $tags = array();

	/**
	 * @var MetaDataDocument[]
	 */
	public $metaData = array();

	/**
	 * @var AuthorDocument
	 */
	public $author;

	/**
	 * @var string
	 */
	public $postType;

	/**
	 * @return string
	 */
	public function getPostStatus() {
		return $this->postStatus;
	}

	/**
	 * @param string $postStatus
	 */
	public function setPostStatus( $postStatus ) {
		$this->postStatus = $postStatus;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl( $url ) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent( $content ) {
		$this->content = $content;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}

	/**
	 * @return CategoryDocument[]
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @param CategoryDocument[] $categories
	 */
	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	/**
	 * @param CategoryDocument $category
	 */
	public function addCategory( CategoryDocument $category ) {
		$this->categories[] = $category;
	}

	/**
	 * @return TagDocument[]
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * @param TagDocument[] $tags
	 */
	public function setTags( $tags ) {
		$this->tags = $tags;
	}

	/**
	 * @param TagDocument $tag
	 */
	public function addTag( TagDocument $tag ) {
		$this->tags[] = $tag;
	}

	/**
	 * @return MetaDataDocument[]
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @param MetaDataDocument[] $metaData
	 */
	public function setMetaData( $metaData ) {
		$this->metaData = $metaData;
	}

	/**
	 * @param MetaDataDocument $metaData
	 */
	public function addMetaData( MetaDataDocument $metaData ) {
		$this->metaData[] = $metaData;
	}

	/**
	 * @return AuthorDocument
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * @param AuthorDocument $author
	 */
	public function setAuthor( $author ) {
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getPostType() {
		return $this->postType;
	}

	/**
	 * @param string $postType
	 */
	public function setPostType( $postType ) {
		$this->postType = $postType;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$normalized = get_object_vars( $this );
		$body       = array();

		/** @var CategoryDocument $category */
		foreach ( $normalized['categories'] as $category ) {
			$body['categories'][] = $category->getName();
		}
		/** @var TagDocument $tag */
		foreach ( $normalized['tags'] as $tag ) {
			$body['tags'][] = $tag->getName();
		}
		/** @var MetaDataDocument $metaData */
		foreach ( $normalized['metaData'] as $metaData ) {
			$body['metaData'][$metaData->getName()] = $metaData->getValue();
		}

		if ( $this->getAuthor() instanceof AuthorDocument ) {
			$body['author']['name']      = $this->getAuthor()->getName();
			$body['author']['last_name'] = $this->getAuthor()->getLastName();
			$body['author']['gravatar']  = $this->getAuthor()->getGravatar();
		}

		$normalized = array_merge( $normalized, $body );

		return $normalized;
	}

}