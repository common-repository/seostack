<?php

namespace SeoStackWP\Admin\Controllers;

use SeoStackWP\Api\ApiDocument;
use SeoStackWP\Api\ApiService;
use SeoStackWP\Api\CategoryDocument;
use SeoStackWP\Api\TagDocument;

/**
 * Class AjaxController
 * @package SeoStackWP\Admin\Controllers
 */
class AjaxController {

	const INDEX_POSTS_PER_PAGE = 10;

	/**
	 * @var ApiService
	 */
	private $apiService;

	/**
	 * SettingsController constructor.
	 *
	 * @param ApiService $apiService
	 */
	public function __construct( ApiService $apiService ) {
		$this->apiService = $apiService;
	}

	/**
	 *
	 * @return string
	 */
	public function batchIndexAction() {
		$start = filter_input( INPUT_POST, 'start' );

		if ( $start == 0 ) {
			$total = $this->apiService->pushBatchToSeoStackAPI( 1 );
		} else {
			$total = $this->apiService->pushBatchToSeoStackAPI( $start );
		}

		$total = ( self::INDEX_POSTS_PER_PAGE * ( $start - 1 ) ) + $total;

		echo json_encode( array(
			'status'    => 'finished',
			'page'      => $start,
			'offset'    => self::INDEX_POSTS_PER_PAGE,
			'completed' => $total
		) );
		exit;
	}

	/**
	 * This function is hooked when a post is saved, so we have to update it in the seostack API.
	 *
	 * @param int $postId
	 */
	public function upsertPostAction( $postId ) {
		$apiDocument = $this->apiService->buildApiDocumentFromPostId( $postId );

		if ( $apiDocument->getPostStatus() !== 'publish' ) {
			$this->apiService->deletePostFromSeoStackAPI( $apiDocument );

			return;
		}


		$this->apiService->upsertPostToSeoStackAPI( $apiDocument );
	}

	/**
	 * This function is hooked when a post is saved, so we have to update it in the seostack API.
	 *
	 * @param int $postId
	 */
	public function deletePostAction( $postId ) {
		$permalink = get_the_permalink( $postId );

		if ( empty( $permalink ) ) {
			return;
		}

		$apiDocument = new ApiDocument();
		$apiDocument->setUrl( $permalink );

		$this->apiService->deletePostFromSeoStackAPI( $apiDocument );
	}

}