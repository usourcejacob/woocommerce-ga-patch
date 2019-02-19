<?php
/**
* Plugin Name: Google Analytics Patch for WooCommerce
* Plugin URI: https://usource.me/
* Description: This plugin prevents WooCommerce Google Analytics integration from tracking WooCommerce page twice when using a 3rd party Google Analytics installation across the site. 
* Version: 1.0
* Author: USource
* Author URI: https://usource.me/
**/

function patch_woo_google_analytics () {
	if ( ! is_admin() && class_exists( 'WC_Google_Analytics_JS' ) ) {
		add_filter( 'woocommerce_ga_snippet_output', '__return_empty_string' );
		add_action( 'wp_footer', array( 'WC_Google_Analytics_JS', 'universal_analytics_footer' ) );
		function replace_pageview_to_event ($js) {
			return str_replace(
				"ga( 'send', 'pageview' );",
				"window.ga && ga( 'send', 'event', 'ecommerce', 'loaded'); // hit to send ecommerce data",
				$js
			);
		}
		add_filter( 'woocommerce_queued_js', 'replace_pageview_to_event' );
	}
}
add_action( 'init', 'patch_woo_google_analytics' );
