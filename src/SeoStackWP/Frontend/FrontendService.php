<?php

namespace SeoStackWP\Frontend;

use SeoStackWP\Datasource\WordPressDatasource;

/**
 * Class FrontendService
 * @package SeoStackWP\Frontend
 */
class FrontendService {

	/**
	 * @var WordPressDatasource
	 */
	private $datasource;

	/**
	 * FrontendService constructor.
	 *
	 * @param WordPressDatasource $datasource
	 */
	public function __construct( WordPressDatasource $datasource ) {
		$this->datasource = $datasource;
	}

	/**
	 * Get the frontend CSS, from the given settings.
	 *
	 * @return string
	 */
	public function getCss() {
		$liveSearchColors = $this->datasource->getLiveSearchSettings();

		$style = '<style type="text/css" media="screen">';
		$style .= '#seostack-suggest-box{background: ' . $liveSearchColors['bg_color'] . ';border: ' . $liveSearchColors['border_size'] . 'px solid ' . $liveSearchColors['border_color'] . ';}';
		$style .= 'ul#seostack-suggest li a{color: ' . $liveSearchColors['link_color'] . ';}';
		$style .= 'ul#seostack-suggest li a:hover, ul#seostack-suggest li a:active, ul#seostack-suggest li a:focus{color: ' . $liveSearchColors['link_color_hover'] . ';}';
		$style .= '</style>';

		return $style;
	}


}