<?php
get_header(); ?>
	<?php the_slideshow(); ?>
	<div id="content" class="site-content" role="main">

		<h1><?php the_title(); ?></h1>

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					the_content();
					
					// Patients Families Query
					$args = array(
						'post_type' => 'events',
						'tax_query' => array(
							array(
								'taxonomy' => 'eventtype',
								'field' => 'slug',
								'terms' => array( 'for-patients-families' )
							),
						),
						'orderby'	=> 'menu_order',
						'order'		=> 'ASC',
						'posts_per_page' => -1
					);
					$event_query = new WP_Query( $args );
					
					mh_display_events($event_query);
					
					// Volunteers Query
					$args = array(
						'post_type' => 'events',
						'tax_query' => array(
							array(
								'taxonomy' => 'eventtype',
								'field' => 'slug',
								'terms' => array( 'for-volunteers' )
							),
						),
						'orderby'	=> 'menu_order',
						'order'		=> 'ASC',
						'posts_per_page' => -1
					);
					$event_query = new WP_Query( $args );
					
					mh_display_events($event_query);
					
					// Everyone Query
					$args = array(
						'post_type' => 'events',
						'tax_query' => array(
							array(
								'taxonomy' => 'eventtype',
								'field' => 'slug',
								'terms' => array( 'for-everyone' )
							),
						),
						'orderby'	=> 'menu_order',
						'order'		=> 'ASC',
						'posts_per_page' => -1
					);
					$event_query = new WP_Query( $args );
					
					//print_r($event_query);
					
					mh_display_events($event_query);
					
				endwhile;

			endif;
			
			function mh_display_events($event_query) {
				// The Loop
				if ( $event_query->have_posts() ) {
					$taxname = get_term_by('slug', $event_query->query_vars['term'], 'eventtype');
					echo '<div class="events">';
					echo '<h2>'.$taxname->name.'</h2>';
					echo '<div class="accordion">';
						while ( $event_query->have_posts() ) {
							$event_query->the_post();
							echo '<h3 class="evtname">'.get_the_title().' <span class="info">'.get_field('dates').'<span class="more">more...</span></span></h3>';
							echo '<div>';
								the_content();
							echo '</div>';
						}
					echo '</div>';
					echo '</div>';
				} else {
					// no posts found
				}
				/* Restore original Post Data */
				wp_reset_postdata();
				
			} //mh_display_board($staff_query);

		?>

	</div><!-- #content -->

<?php
get_footer();
