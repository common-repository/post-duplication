<?php 
/**
 * Create the metabox class
 */
if( !class_exists('PDWP_POST_DUPLICATION_MetaBox') ) {

	class PDWP_POST_DUPLICATION_MetaBox {
	
	  public function __construct( $meta_box ) {
	
	  	if ( !is_admin() ) return;
	  	
	  	// Save the meta box data
	  	$this->mb = $meta_box;
	  	$this->mb_fields = &$this->mb['fields'];
		
	    add_action( 'add_meta_boxes', array(&$this, 'pdwp_post_duplication_metabox_add') );
	    add_action( 'save_post', array(&$this, 'pdwp_post_duplication_metabox_save') );
	  }
		
		/**
		 * Create the metaboxes
		 */
		public function pdwp_post_duplication_metabox_add() {
		
			foreach ( $this->mb['page'] as $page ) {
		    add_meta_box( $this->mb['id'], $this->mb['title'], array(&$this, 'pdwp_post_duplication_metabox_render_content'), $page, $this->mb['context'], $this->mb['priority'] );
	  	}
		}
	
		/**
		 * Render the metabox content
		 */
	  public function pdwp_post_duplication_metabox_render_content() {
	  	?>
	  	<table style="width:100%;" class="pdwp-post-duplication-metabox-admin-fields wrap">
	      <?php 
	      foreach( $this->mb_fields as $field ) {
	
					if ( isset( $field['id'] ) ) {
						// Create a nonce field
						echo'<input type="hidden" name="'.$field['id'].'_noncename"  id="'.$field['id'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
					}
					
					// Output the field
					pdwp_post_duplication_metabox_container( $field, $this->mb['context'] );
				}
				?>
			</table>
			<?php
	  }
	
		/**
		 * Save the field values
		 */
	  public function pdwp_post_duplication_metabox_save( $post_id ) {
			
			global $post;
			
			foreach( $this->mb_fields as $field ) {
	
				if ( isset($field['id']) ) {
		        	
		    	if ( isset($_POST[$field['id'].'_noncename']) ) {
						
						// Verify the nonce and return if false
						if ( !wp_verify_nonce($_POST[$field['id'].'_noncename'], plugin_basename(__FILE__)) ) {
							return  $post_id;
						}
						
						// Make sure the user can edit pages & posts
						if ( 'page' == $_POST['post_type'] ) {
							if ( !current_user_can('edit_page', $post_id) ) {
								return $post_id;
							}
						} else {
							if ( !current_user_can('edit_post', $post_id) ) {
								return $post_id;
							}
						}
						
						// Store the user data or set as empty string
						$data = ( isset($_POST[$field['id']]) ) ? $_POST[$field['id']] : '';
						
						// Update the meta
						pdwp_post_duplication_metabox_update_meta( $post_id, $field['id'], $field['type'], $data );
						
						// Save appended fields
						pdwp_post_duplication_metabox_save_appended( $post_id, $field );
						
						// Save row fields
						pdwp_post_duplication_metabox_save_rows( $post_id, $field );
					}
				}
			}
		}
	}
	
	/**
	 * Save the row field values
	 */
  function pdwp_post_duplication_metabox_save_rows( $post_id, $field ) {
  
  	if( isset($field['rows']) ) {
  	
			foreach( $field['rows'] as $id => $row ) {
				
				$row_id = $row['id'];
				
				// Store the user data or set as empty string
				$data = ( isset($_POST[$row_id]) ) ? $_POST[$row_id] : '';
				
				// Update the meta
				pdwp_post_duplication_metabox_update_meta( $post_id, $row_id, $row['type'], $data );
				
				// Save appended fields
				pdwp_post_duplication_metabox_save_appended( $post_id, $row );
			}
		}
  }
		
	/**
	 * Save the appended field values
	 */
  function pdwp_post_duplication_metabox_save_appended( $post_id, $field ) {

		if( isset($field['append']) ) {
		
			foreach( $field['append'] as $id => $append ) {
				
				// Store the user data or set as empty string
				$data = ( isset($_POST[$id]) ) ? $_POST[$id] : '';
				
				// Update the meta
				pdwp_post_duplication_metabox_update_meta( $post_id, $id, $append['type'], $data );
			}
		}
	}
	
	/**
	 * Update the meta
	 */
  function pdwp_post_duplication_metabox_update_meta( $post_id, $id, $type, $data ) {
  	
  	// Update the post meta
  	update_post_meta( $post_id, $id, $data );
  }
	
}