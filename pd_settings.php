<?php

add_action( 'admin_menu', 'pdwp_post_duplication_settings_page' );
/**
 * Add a menu page to display options
 */
function pdwp_post_duplication_settings_page() {

	add_management_page(__('Post Duplication', 'post-duplication'),	__('Post Duplication', 'post-duplication'), 
'administrator', 'pdwp_post_duplication_settings_menu', 'pdwp_post_duplication_settings_display' );
}
add_action( 'admin_init', 'pdwp_post_duplication_initialize_settings' );


/**
 * Initializes the options page.
 */ 
function pdwp_post_duplication_initialize_settings() {

	$settings['type'] = array(
		'title' => __( 'Post Type', 'post-duplication' ),
		'type' => 'select',
		'options' => pdwp_post_duplication_post_types(),
		'default' => 'same'
	);
	
	$settings['status'] = array(
		'title' => __( 'Post Status', 'post-duplication' ),
		'type' => 'select',
		'options' => array(
			'same' => __('Same as original', 'post-duplication'),
			'draft' => __('Draft', 'post-duplication'),
			'publish' => __('Published', 'post-duplication'),
			'pending' => __('Pending', 'post-duplication')	
		),
		'default' => 'draft'
	);
	
	$settings['title'] = array(
		'title' => __( 'Duplicate Title', 'post-duplication' ),
		'description' => __('String that should be appended to the duplicate post\'s title', 'post-duplication'),
		'type' => 'text',
		'display' => 'inline',
		'default' => __('Copy', 'post-duplication')
	);
	
	$settings['slug'] = array(
		'title' => __( 'Duplicate Slug', 'post-duplication' ),
		'description' => __('String that should be appended to the duplicate post\'s slug', 'post-duplication'),
		'type' => 'text',
		'display' => 'inline',
		'default' => 'copy'
	);
	
	$settings['timestamp'] = array(
		'title' => __( 'Post Date', 'post-duplication' ),
		'type' => 'radio',
		'options' => array(
			'duplicate' => __('Duplicate Timestamp', 'post-duplication'),
			'current' => __('Current Time', 'post-duplication')
		),
		'display' => 'inline',
		'default' => 'current'
	);
	
	$settings['time_offset'] = array(
		'title' => __( 'Offset Date', 'post-duplication' ),
		'type' => 'checkbox',
		'append' => array(
			'time_offset_days' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' days', 'post-duplication'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_hours' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' hours', 'post-duplication'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_minutes' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' minutes', 'post-duplication'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_seconds' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' seconds', 'post-duplication'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_direction' => array(
				'type' => 'select',
				'options' => array(
					'newer' => __('newer', 'post-duplication'),
					'older' => __('older', 'post-duplication')
				),
				'default' => 'newer'
			)
		)
	);

	if( false == get_option('pdwp_post_duplication_settings') ) {	
		add_option( 'pdwp_post_duplication_settings' );
	}
	
	/* Register the style options */
	add_settings_section('pdwp_post_duplication_settings_section', '','pdwp_post_duplication_settings_callback','pdwp_post_duplication_settings');
	
	$settings = apply_filters( 'pdwp_post_duplication_settings', $settings );

	if( is_array($settings) ) {
		foreach( $settings as $id => $setting ) {	
			$setting['option'] = 'pdwp_post_duplication_settings';
			$setting['option_id'] = $id;
			$setting['id'] = 'pdwp_post_duplication_settings['.$id.']';
			add_settings_field( $setting['id'], $setting['title'], 'pdwp_post_duplication_field_display', 'pdwp_post_duplication_settings', 'pdwp_post_duplication_settings_section', $setting);
		}
	}
	
	// Register the fields with WordPress
	register_setting( 'pdwp_post_duplication_settings', 'pdwp_post_duplication_settings' );
}

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function pdwp_post_duplication_settings_display() {
	?>
	<div class="wrap pd-wrap">
	
		<h2><?php _e( 'Post Duplication Settings', 'post-duplication' ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'pdwp_post_duplication_settings' );
			do_settings_sections( 'pdwp_post_duplication_settings' );
			submit_button();
			?>
		</form>

	</div><!-- /.wrap -->
	<?php
}

/**
 * The callback function for the settings sections.
 */ 
function pdwp_post_duplication_settings_callback() {
	echo '<h4>' . __( 'Settings for duplicated posts.', 'post-duplication' ) . '</h4>';
}

/**
 * The custom field callback.
 */ 
function pdwp_post_duplication_field_display( $args ) {

	// First, we read the options collection
	if( isset($args['option']) ) {
		$options = get_option( $args['option'] );
		$value = isset( $options[$args['option_id']] ) ? $options[$args['option_id']] : '';
	} else {
		$value = get_option( $args['id'] );
	}	
	if( $value == '' && isset($args['default']) ) {
		$value = $args['default'];
	}
	if( isset($args['type']) ) {
	
		echo '<div class="pdwp-post-duplication-metaboxer-field pdwp-post-duplication-metabox-'.$args['type'].'">';
		
		// Call the function to display the field
		if ( function_exists('pdwp_post_duplication_metabox_'.$args['type']) ) {
			call_user_func( 'pdwp_post_duplication_metabox_'.$args['type'], $args, $value );
		}
		
		echo '<div>';
	}
	
	// Add a descriptions
	if( isset($args['description']) ) {
		echo '<span class="description"><small>'.$args['description'].'</small></span>';
	}
}