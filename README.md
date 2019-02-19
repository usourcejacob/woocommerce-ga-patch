# Google Analytics Patch for WooCommerce

This plugin prevents WooCommerce Google Analytics integration from tracking WooCommerce pages twice when using a 3rd party or manual Google Analytics installation across the site. 

## Installation
    
    mkdir google-analytics-patch-for-woocommerce && cd google-analytics-patch-for-woocommerce
    git clone https://github.com/usourcejacob/woocommerce-ga-patch.git
or

Download this repository as a .zip file and upload it to your WordPress site using the plugin manager of via FTP/SFTP.

Alternatively, you can implement this patch without using this plugins. Modify your theme's  _functions.php_ and adding the code from the plugin's source code

## Notes
Use this plugin only when you are using WooCommerce Google Analytics Integration : https://wordpress.org/plugins/woocommerce-google-analytics-integration/
