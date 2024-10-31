<?php
	
/* 
 * !Array of post types return 
 */

if( !function_exists('pdwp_post_duplication_post_types') ) {
	function pdwp_post_duplication_post_types() {
		
		$post_types = array('same' => __('Same as original', 'post-duplication'));
		$pts = get_post_types(array(), 'objects');
		
		// Remove framework post types
		unset( $pts['attachment'] );
		unset( $pts['revision'] );
		unset( $pts['nav_menu_item'] );
		unset( $pts['wooframework'] );
	
		if( is_array($pts) && count($pts) > 0 ) {
			foreach( $pts as $i=>$pt ) {
				$post_types[$i] = $pt->labels->singular_name;
			}
		}		
		return $post_types;	
	}
}
