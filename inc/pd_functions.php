<?php

/** 
 *If value exists in option table then Return a value from the options table.
 */
 
 
function pdwp_post_duplication_submitbox( $post ) {
	if( $post->post_status == 'publish' ) {
		$post_type = get_post_type_object( $post->post_type );
		$nonce = wp_create_nonce( 'p4d_ajax_file_nonce' );
		?>
		<div class="misc-pub-section misc-pub-duplication" id="duplication">
			<a class="p4d-duplicate-post button button-small" rel="<?php echo $nonce; ?>" href="#" data-postid="<?php echo $post->ID; ?>"><?php printf( __( 'Duplicate %s', 'post-duplication' ), $post_type->labels->singular_name ); ?></a><span class="spinner" style="float:none;margin-top:2px;margin-left:4px;"></span>
		</div>
		<?php
	}
}
add_action( 'post_submitbox_misc_actions', 'pdwp_post_duplication_submitbox' );

function get_pdwp_post_duplication_settings() {
	
	// Get the options
	$settings = get_option('pdwp_post_duplication_settings', array());
	
	$defaults = array(
		'status' => 'same',
		'type' => 'same',
		'timestamp' => 'current',
		'title' => __('Copy', 'post-duplication'),
		'slug' => 'copy',
		'time_offset' => false,
		'time_offset_days' => 0,
		'time_offset_hours' => 0,
		'time_offset_minutes' => 0,
		'time_offset_seconds' => 0,
		'time_offset_direction' => 'newer'
	);
	
	// Filter the settings
	$settings = apply_filters( 'pdwp_post_duplication_settings', $settings );
	
	// Return the settings
	return wp_parse_args( $settings, $defaults );
}

