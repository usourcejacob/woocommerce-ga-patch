<?php
/**
* Plugin Name: Google Analytics Patch for WooCommerce
* Plugin URI: https://usource.me/
* Description: This plugin prevents WooCommerce Google Analytics integration from tracking WooCommerce page twice when using a 3rd party Google Analytics installation across the site. 
* Version: 1.0
* Author: USource
* Author URI: https://usource.me/
**/

function fix_double_google_analytics () {
	if ( ! is_admin() && class_exists( 'WC_Google_Analytics_JS' ) ) {
		// Remove analytics.js script from WooCommerce Google Analytics Integration.
		add_filter( 'woocommerce_ga_snippet_output', '__return_empty_string' );
		// Always add universal_analytics_footer from WooCommerce Google Analytics Integration.
		// Prevent if not is an WC page the ecommerce data is not send with ga( 'send', 'pageview' )
		add_action( 'wp_footer', array( 'WC_Google_Analytics_JS', 'universal_analytics_footer' ) );
		// Replace footer pageview with an event.
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
add_action( 'init', 'fix_double_google_analytics' );