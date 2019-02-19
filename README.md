# Google Analytics Patch for WooCommerce

This plugin prevents WooCommerce Google Analytics integration from tracking WooCommerce pages twice when using a 3rd party or manual Google Analytics installation across the site. 

## Installation
    
    mkdir google-analytics-patch-for-woocommerce && cd google-analytics-patch-for-woocommerce
    git clone https://github.com/usourcejacob/woocommerce-ga-patch.git
or

Download this repository as a .zip file and upload it to your WordPress site using the plugin manager of via FTP/SFTP.

Alternatively, you can implement this patch without using this plugins. Modify your theme's  _functions.php_ and add the following code
    ``` php
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
    ```

## Notes
Use this plugin only when you are using WooCommerce Google Analytics Integration : https://wordpress.org/plugins/woocommerce-google-analytics-integration/
