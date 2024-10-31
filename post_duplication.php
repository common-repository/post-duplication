<?php
/**
 * @link              http://store.wphound.com/?plugin=post-duplication
 * @since             1.0.0
 * @package           Post_Duplication
 *
 * @wordpress-plugin
 * Plugin Name:       Post Duplication
 * Plugin URI:        http://store.wphound.com/?plugin=post-duplication
 * Description:       Creates functionality to duplicate any and all post types, including taxonomies & custom fields
 * Version:           1.0.0
 * Author:            WP Hound
 * Author URI:        http://www.wphound.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-duplication
 */



/**Define Widget Constants */
define ( 'PDWP_POST_DUPLICATION_VERSION', '1.0' );
define ( 'PDWP_POST_DUPLICATION_DIR', plugin_dir_path(__FILE__) );
define ( 'PDWP_POST_DUPLICATION_DIR_NAME', plugins_url(null, __FILE__) . '/');	

add_action( 'plugins_loaded', 'pdwp_post_duplication_localization' );
/**
 * Setup localization
 */
function pdwp_post_duplication_localization() {
	load_plugin_textdomain( 'post-duplication', false, PDWP_POST_DUPLICATION_DIR.'inc/languages/' );
}

/**
 * Include files.
 */
if ( is_admin() ) {

	// Load metabox
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_helpers.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_metabox.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_metabox-class.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_scripts.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_ajax.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_edit.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_functions.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'inc/pd_notices.php' );
	require_once( PDWP_POST_DUPLICATION_DIR.'pd_settings.php' );
}