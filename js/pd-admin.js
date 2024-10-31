jQuery( document ).ready( function() {

/**
 * Duplicate post listener.
 * Creates an ajax request that creates a new post, 
 * duplicating custom meta and all the data.
 */
 
	jQuery( '.p4d-duplicate-post' ).live( 'click', function( e ) {
		
		e.preventDefault();
		var $spinner = jQuery(this).next('.spinner');
		$spinner.css('visibility', 'visible');
	
		// Create the data to pass
		var data = {
			action: 'p4d_duplicate_post',
			original_id: jQuery(this).data('postid'),
			security: jQuery(this).attr('rel')
		};
	
		jQuery.post( ajaxurl, data, function( response ) {
			
			var location = window.location.href;
			if( location.split('?').length > 1 ) {
				location = location + '&post-duplicated='+response;
			} else {
				location = location + '?post-duplicated='+response;
			}
			
			window.location.href = location;
		});
	});
});