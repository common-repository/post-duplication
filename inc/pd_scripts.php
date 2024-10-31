<?php

/**
 * Add the necessary jquery.
 */
add_action( 'admin_enqueue_scripts', 'p4d_duplicate_post_scripts' );

function p4d_duplicate_post_scripts( $hook_suffix ) {
	wp_enqueue_script( 'pdwp-post-duplication',PDWP_POST_DUPLICATION_DIR_NAME.'js/pd-admin.js', array('jquery'), PDWP_POST_DUPLICATION_VERSION );
}

/**
 * Load the metabox CSS
 */
add_action( 'admin_enqueue_scripts', 'pdwp_post_duplication_metabox_scripts' );

function pdwp_post_duplication_metabox_scripts( $hook ) {
	
		if( $hook == 'tools_page_pdwp_post_duplication_settings_menu' ) {
		
		// Load the style sheet
		wp_register_style( 'pdwp-post-duplication-metabox', PDWP_POST_DUPLICATION_DIR_NAME.'inc/pd_metabox.css', false, PDWP_POST_DUPLICATION_VERSION );
		wp_enqueue_style( 'pdwp-post-duplication-metabox' );
	}
}

wp_enqueue_style('post-duplicate-css',PDWP_POST_DUPLICATION_DIR_NAME.'css/pd-admin-css.css', false, PDWP_POST_DUPLICATION_VERSION); 
