<?php
get_header(); ?>
	<?php the_slideshow(); ?>
	<div id="content" class="site-content" role="main">

		<h1><?php the_title(); ?></h1>
		
		<?php 
		
		$terms = get_terms( array(
			'taxonomy' => 'eventtype'
		) );
		
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			echo '<ul id="evtterm">';
			foreach ( $terms as $term ) {
				echo '<li><a href="#' . $term->slug . '">' . $term->name . '</a></li>';
			}
			echo '</ul>';
		}
		?> 

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
					echo '<div class="events" id="'.$event_query->query_vars['term'].'">';
					echo '<h2>'.$taxname->name.'</h2>';
					echo '<ul>';
						while ( $event_query->have_posts() ) {
							$event_query->the_post();
							echo '<li>';
								echo '<div class="evtname">'.get_the_title().'</div>';
								the_content();
							echo '</li>';
						}
					echo '</ul>';
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
