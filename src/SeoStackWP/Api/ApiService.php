<?php

namespace SeoStackWP\Api;

use SeoStackWP\Admin\Controllers\AjaxController;
use SeoStackWP\Datasource\DatasourceInterface;
use SeoStackWP\Datasource\WordPressDatasource;

/**
 * Class ApiService
 * @package SeoStackWP\Api
 */
class ApiService {

	/**
	 * @var array
	 */
	private $supportedPostTypes = array();

	/**
	 * @var WordPressDatasource
	 */
	private $datasource;

	/**
	 * ApiService constructor.
	 *
	 * @param DatasourceInterface $datasource
	 */
	public function __construct( DatasourceInterface $datasource ) {
		$this->datasource = $datasource;
	}

	/**
	 * Get the information about the existing API key on this website.
	 *
	 * @return null
	 */
	public function getApiKeyInfo() {
		$apiKey = $this->datasource->getApiKey();

		if ( !empty( $apiKey ) ) {
			$response = wp_remote_post( SEOSTACK_API_ENDPOINT . 'api/domains/validate?key=' . $this->datasource->getApiKey(), array(
					'method'      => 'GET',
					'timeout'     => 10,
					'redirection' => 3,
					'httpversion' => '1.0',
					'blocking'    => true,
				)
			);

			$result = json_decode( $response['body'] );

			if ( isset( $result->data ) ) {
				return $result->data;
			}
		}

		return null;
	}

	/**
	 * Get the total amount of posts which are published on this website. Currently supporting a few custom post types.
	 *
	 * @return int
	 */
	public function getPublishedPostsCount() {
		$total = 0;

		foreach ( $this->getSupportedPostTypes() as $type ) {
			$posts = wp_count_posts( $type );

			if ( isset( $posts->publish ) ) {
				$total += (int) $posts->publish;
			}
		}

		return $total;
	}

	/**
	 * @param int $startPage
	 *
	 * @return bool|int
	 * @internal param int $start
	 */
	public function pushBatchToSeoStackAPI( $startPage = 0 ) {
		$args      = array(
			'post_type'      => $this->getSupportedPostTypes(),
			'post_status'    => 'publish',
			'paged'          => $startPage,
			'posts_per_page' => AjaxController::INDEX_POSTS_PER_PAGE
		);
		$posts     = get_posts( $args );
		$completed = 0;

		$data = array();

		foreach ( $posts as $post ) {
			$apiDocument = $this->buildApiDocumentFromPostId( $post->ID );

			$data[] = $apiDocument->toArray();

			$completed ++;
		}

		$response = wp_remote_post( SEOSTACK_API_ENDPOINT . 'api/upsert?key=' . $this->datasource->getApiKey(), array(
				'method'      => 'POST',
				'timeout'     => 20,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'body'        => array(
					'bulk' => $data
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		return $completed;
	}

	/**
	 * Upsert a post/page/item to the seostack API. Upsert = update or insert.
	 *
	 * @param ApiDocument $apiDocument
	 *
	 * @return bool
	 */
	public function upsertPostToSeoStackAPI( ApiDocument $apiDocument ) {
		$apiDocumentArray = $apiDocument->toArray();

		$response = wp_remote_post( SEOSTACK_API_ENDPOINT . 'api/upsert?key=' . $this->datasource->getApiKey(), array(
				'method'      => 'POST',
				'timeout'     => 20,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'body'        => $apiDocumentArray,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Delete a post, so also delete it in the seostack API.
	 *
	 * @param ApiDocument $apiDocument
	 *
	 * @return bool
	 */
	public function deletePostFromSeoStackAPI( ApiDocument $apiDocument ) {
		$response = wp_remote_post( SEOSTACK_API_ENDPOINT . 'api/delete?key=' . $this->datasource->getApiKey(), array(
				'method'      => 'POST',
				'timeout'     => 20,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'body'        => array(
					'url' => $apiDocument->getUrl(),
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if the site is completely indexable.
	 *
	 * @param $apiKeyLimit
	 * @param $documentCount
	 *
	 * @return bool
	 */
	public function isCompletelyIndexable( $apiKeyLimit, $documentCount ) {
		if ( $apiKeyLimit > $documentCount ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the API key
	 *
	 * @return mixed
	 */
	public function getApiKey() {
		return $this->datasource->getApiKey();
	}

	/**
	 * Is the installation completed.
	 *
	 * @return bool
	 */
	public function isInstallationCompleted() {
		return $this->datasource->isInstallationCompleted();
	}

	/**
	 * @return array
	 */
	public function getSupportedPostTypes() {
		$postTypes = get_post_types( array(
			'public' => true,
		), 'objects' );

		foreach ( $postTypes as $postType ) {
			if ( !isset( $postType->name ) || $postType->name === 'attachment' ) {
				continue;
			}

			$this->supportedPostTypes[] = $postType->name;
		}

		return $this->supportedPostTypes;
	}

	/**
	 * Build a API Document from a post id.
	 *
	 * @param $postId
	 *
	 * @return ApiDocument
	 */
	public function buildApiDocumentFromPostId( $postId ) {
		$postData = get_post( $postId );

		$apiDocument = new ApiDocument();
		$apiDocument->setPostStatus( $postData->post_status );
		$apiDocument->setPostType( $postData->post_type );

		$tags       = wp_get_post_tags( $postId );
		$categories = wp_get_post_categories( $postId );

		if ( !empty( $postData->post_author ) && $postData->post_author !== false ) {
			$author = new AuthorDocument();
			$author->setName( get_the_author_meta( 'first_name', $postData->post_author ) );
			$author->setLastName( get_the_author_meta( 'last_name', $postData->post_author ) );
			$author->setGravatar( md5( get_the_author_meta( 'user_email', $postData->post_author ) ) );
			$apiDocument->setAuthor( $author );
		}

		$apiDocument->setTitle( get_the_title( $postId ) );
		$apiDocument->setUrl( get_the_permalink( $postId ) );
		$apiDocument->setContent( $postData->post_content );
		$apiDocument->setDescription( $postData->post_excerpt );

		if ( $postData->post_status !== 'publish' ) {
			return $apiDocument;
		}

		foreach ( $tags as $tag ) {
			$tagDocument = new TagDocument();
			$tagDocument->setName( $tag->name );

			$apiDocument->addTag( $tagDocument );
		}

		foreach ( $categories as $category ) {
			$catInfo = get_category( $category );

			$categoryDocument = new CategoryDocument();
			$categoryDocument->setName( $catInfo->name );

			$apiDocument->addCategory( $categoryDocument );
		}

		if ( class_exists( 'WPSEO_Meta' ) ) {
			$focusKeyword = \WPSEO_Meta::get_value( 'focuskw', $postId );
			if ( !empty( $focusKeyword ) ) {
				$seoFocusKeyword = new MetaDataDocument();
				$seoFocusKeyword->setName( 'seo_focus_keyword' );
				$seoFocusKeyword->setValue( \WPSEO_Meta::get_value( 'focuskw', $postId ) );
				$apiDocument->addMetaData( $seoFocusKeyword );
			}

			$metaDescription = \WPSEO_Meta::get_value( 'metadesc', $postId );
			if ( !empty( $metaDescription ) ) {
				$seoMetaDescription = new MetaDataDocument();
				$seoMetaDescription->setName( 'seo_meta_description' );
				$seoMetaDescription->setValue( \WPSEO_Meta::get_value( 'metadesc', $postId ) );
				$apiDocument->addMetaData( $seoMetaDescription );
			}
		}

		if ( $postData->post_type === 'product' || function_exists( 'wc_get_product' ) ) {
			$apiDocument = $this->enrichApiDocumentForProduct( $postId, $apiDocument );
		}

		// @TODO add a filter or action to implement more meta tags and push them to the API.

		return $apiDocument;
	}

	/**
	 * Enrich a given API document with product data.
	 *
	 * @param             $postId
	 * @param ApiDocument $apiDocument
	 *
	 * @return ApiDocument
	 */
	private function enrichApiDocumentForProduct( $postId, ApiDocument $apiDocument ) {
		$productData = wc_get_product( $postId );

		if ( $productData === false ) {
			// No product data found, return document and continue with indexing.

			return $apiDocument;
		}

		$categories = $productData->get_category_ids();
		foreach ( $categories as $categoryId ) {
			$catInfo = get_category( $categoryId );

			$categoryDocument = new CategoryDocument();
			$categoryDocument->setName( $catInfo->name );

			$apiDocument->addCategory( $categoryDocument );
		}

		$tags = $productData->get_tag_ids();
		foreach ( $tags as $tag ) {
			$tagInfo     = get_tag( $tag );
			$tagDocument = new TagDocument();
			$tagDocument->setName( $tagInfo->name );

			$apiDocument->addTag( $tagDocument );
		}

		$metaRegularPrice = $productData->get_regular_price();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_regular_price' );
			$metaElement->setValue( $metaRegularPrice );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaSalePrice = $productData->get_sale_price();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_sale_price' );
			$metaElement->setValue( $metaSalePrice );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaPrice = $productData->get_price();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_price' );
			$metaElement->setValue( $metaPrice );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaSku = $productData->get_sku();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_sku' );
			$metaElement->setValue( $metaSku );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaFeatured = $productData->is_featured();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_featured' );
			$metaElement->setValue( $metaFeatured );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaStock = $productData->is_in_stock();
		if ( !empty( $metaRegularPrice ) ) {
			$metaElement = new MetaDataDocument();
			$metaElement->setName( 'product_in_stock' );
			$metaElement->setValue( $metaStock );
			$apiDocument->addMetaData( $metaElement );
		}

		$metaImage = $productData->get_image_id();
		if ( !empty( $metaImage ) ) {
			$image = wp_get_attachment_image_src( $metaImage );

			if ( !empty( $image[0] ) ) {
				$metaElement = new MetaDataDocument();
				$metaElement->setName( 'product_image_url' );
				$metaElement->setValue( $image[0] );
				$apiDocument->addMetaData( $metaElement );
			}
		}

		return $apiDocument;
	}

}