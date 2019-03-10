<?php
/**
 * The Login template file
 */

get_header(); ?>
	<?php the_slideshow(); ?>
	<div id="content" class="site-content" role="main">

		<h1><?php the_title(); ?></h1>

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					the_content();
					
					//set current page	
					$location = get_permalink($post->ID);
										
					if ( ! is_user_logged_in() ) { // Display WordPress login form:
						$args = array(
							'redirect' => $location,
						);
						wp_login_form($args);
					} else {
						if ( current_user_can('board_member') )
							$location = get_permalink(3840);
							
						if ( current_user_can('volunteer') )
							$location = get_permalink(104);
						
						wp_safe_redirect($location);
						exit;
					}

				endwhile;

			endif;
			
			/**
			 * WordPress function for redirecting users on login based on user role
			 */
			function mh_login_redirect( $location, $request, $user ){
				if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
					if ( current_user_can('board_member') )
						$location = get_permalink(3840);
						
					if ( current_user_can('volunteer') )
						$location = get_permalink(104);
				}
				return $location;
			}
			
			add_filter('login_redirect', 'mh_login_redirect', 10, 3 );
		?>

	</div><!-- #content -->
<?php
get_footer();
