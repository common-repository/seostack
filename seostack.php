<?php
/*
Plugin Name: SEOStack - Internal Site Search
Plugin URI: https://wordpress.org/plugins/seostack/
Description: Optimize your internal site search with live search and our professional algorithm. This plugin uses the SEOStack API, for the best performance and instant updates.
Version: 1.0.1
Author: petervw
Author URI: https://seostack.io
Text Domain: seostack
Domain Path: /languages
*/


define( 'SEOSTACK_VERSION', '1.0.1' );

define( 'SEOSTACK_API_ENDPOINT', 'https://search.api.seostack.io/' );

define( 'SEOSTACK_PLUGIN_ROOT', __FILE__ );

define( 'SEOSTACK_PLUGIN_ROOT_DIR', dirname( __FILE__ ) );

require dirname( SEOSTACK_PLUGIN_ROOT ) . '/vendor/autoload.php';

$application = new \SeoStackWP\Init();

add_action( 'init', array( $application, 'init' ) );
add_action( 'plugins_loaded', array( $application, 'loadPluginTranslations' ) );
