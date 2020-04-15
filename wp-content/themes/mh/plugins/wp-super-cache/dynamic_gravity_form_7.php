<?php

// Dynamically swap out a tag or text for the gravity form so it's dynamic
define( 'DYNAMIC_OUTPUT_BUFFER_TAG', '<div id="dynamic_gravity_form_7"></div>' );
if ( '' !== DYNAMIC_OUTPUT_BUFFER_TAG ) {
	function dynamic_output_buffer_test( $cachedata = 0 ) {
		if ( defined( 'DYNAMIC_OB_TEXT' ) ) {
			return str_replace( DYNAMIC_OUTPUT_BUFFER_TAG, DYNAMIC_OB_TEXT, $cachedata );
		}

		ob_start();
		// call the sidebar function, do something dynamic
		gravity_form( 7, false, true, false, null, true );
		?>
		<script>
		jQuery('div#gform_wrapper_7').css('display', 'block');
		</script>
		<?php
		$text = ob_get_contents();
		ob_end_clean();

		if ( 0 === $cachedata ) { // called directly from the theme so store the output.
			define( 'DYNAMIC_OB_TEXT', $text );
		} else { // called via the wpsc_cachedata filter. We only get here in cached pages in wp-cache-phase1.php.
			return str_replace( DYNAMIC_OUTPUT_BUFFER_TAG, $text, $cachedata );
		}

	}
	add_cacheaction( 'wpsc_cachedata', 'dynamic_output_buffer_test' );

	function dynamic_output_buffer_init() {
		add_action( 'wp_footer', 'dynamic_output_buffer_test' );
	}
	add_cacheaction( 'add_cacheaction', 'dynamic_output_buffer_init' );

	function dynamic_output_buffer_test_safety( $safety ) {
		if ( defined( 'DYNAMIC_OB_TEXT' ) ) {// this is set when you call dynamic_output_buffer_test() from the theme.
			return 1; // ready to replace tag with dynamic content.
		} else {
			return 0; // tag cannot be replaced.
		}
	}
	add_cacheaction( 'wpsc_cachedata_safety', 'dynamic_output_buffer_test_safety' );
}