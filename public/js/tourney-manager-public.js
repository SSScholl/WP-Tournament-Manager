(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 jQuery(function() {
		jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
	  });
	  
	  /* Change selected player in editor. */
	  jQuery( '.wptournregedit-select' ).on( 'change', function() {
	  
		  jQuery( '.wptournregedit-participant' ).css( 'display', 'none' );
		  jQuery( jQuery( this ).val() ).css( 'display', 'block' );
		  
	  }).trigger( 'change' );
	  
	  /* Approve player. */
	  jQuery( '.wptournregedit-participant').each( function() {
		  
		  let form = jQuery( this );
		  let select = jQuery( '.wptournregedit-select>[value="#wptournregedit-participant' + form.find( '[name=id]' ).val() + '"]' );
		  form.find( '[name=approved]' ).on( 'change', function() {
			  
			  if ( jQuery( this ).is( ':checked' ) ) {
				  
				  select.removeClass( 'wptournregedit-not-approved' );
			  }
			  else {
				  
				  select.addClass( 'wptournregedit-not-approved' );
			  }
		  });
	  });
	  
	  /* Check for bots */
	  var wptournregtouched = false;
	  jQuery( '.wptournreg-form input' ).on( 'focus mouseover touch', function() {
		  
		  if ( wptournregtouched === false ) {
			  
			  wptournregtouched = true;
			  jQuery( '.wptournreg-form' ).prepend( '<input type="hidden" name="touched" value="1">' );
		  }
	  });

})( jQuery );
