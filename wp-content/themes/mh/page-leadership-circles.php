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
					
					//Build the table
					echo '<div id="leaders_circle">';
					
						if( have_rows('left_side') ):
									
							echo '<div class="lc_col">';
						
							while ( have_rows('left_side') ) : the_row();
							
								if( get_row_layout() == 'donors' ):
								
									$ls_heading = get_sub_field('heading');
								
									$ls_donors = get_sub_field('donors');
								
									echo '<p><strong>'.$ls_heading.'</strong><br>'.$ls_donors.'</p>';
									
								endif;
						 
							endwhile;
							
							echo '</div>';
						
						endif;
					
						if( have_rows('right_side') ):
									
							echo '<div class="lc_col">';
						
							while ( have_rows('right_side') ) : the_row();
							
								if( get_row_layout() == 'donors' ):
								
									$ls_heading = get_sub_field('heading');
								
									$ls_donors = get_sub_field('donors');
								
									echo '<p><strong>'.$ls_heading.'</strong><br>'.$ls_donors.'</p>';
									
								endif;
						 
							endwhile;
							
							echo '</div>';
						
						endif;
						
					echo '</div>';
						
					/* Restore original Post Data */
					wp_reset_postdata();

				endwhile;

			endif;
		?>

	</div><!-- #content -->

<?php
get_footer();
