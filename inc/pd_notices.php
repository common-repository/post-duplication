<?php

/* 
 * !Create an admin notice that a post has been duplicated  
 */

function pdwp_post_duplication_notice() {
	
	$duplicated_id = isset($_GET['post-duplicated']) ? htmlspecialchars($_GET['post-duplicated'], ENT_QUOTES, 'UTF-8') : '';
	if( $duplicated_id != '' ) {
		
		$settings = get_pdwp_post_duplication_settings();
	
		// Get the post type object
		$duplicated_post = get_post($duplicated_id);
		$post_type = get_post_type_object( $duplicated_post->post_type );
		
		// Set the button label
		$pt = $post_type->labels->singular_name;
		$link = '<a href="'.get_edit_post_link($duplicated_id).'">'.__('here', 'post-duplication').'</a>';
		$label = sprintf( __( 'Successfully Duplicated! You can edit your new %1$s %2$s.', 'post-duplication' ), $pt, $link );
		
		?>
    <div class="updated">
       <p><?php echo $label; ?></p>
    </div>
    <?php
	}
}
add_action('admin_notices', 'pdwp_post_duplication_notice');