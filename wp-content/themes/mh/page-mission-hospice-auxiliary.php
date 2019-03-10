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
					
					// Officers
					if( have_rows('officers') ):
					
						while ( have_rows('officers') ) : the_row();
	 
							$officer_name = get_sub_field('name');
							$officer_position = get_sub_field('position');
							
							//Store the list
							$officer_info .= $officer_name . ', <span>' . $officer_position . '</span><br>';
					 
						endwhile;
					
					endif;
					
					// Standing Committes
					if( have_rows('standing_committees') ):
					
						while ( have_rows('standing_committees') ) : the_row();
	 
							$standing_committees_name = get_sub_field('name');
							$standing_committees_position = get_sub_field('position');
							
							//Store the list
							$standing_committees_info .= $standing_committees_name . ', <span>' . $standing_committees_position . '</span><br>';
					 
						endwhile;
					
					endif;
					
					// Active Members
					if( have_rows('active_members') ):
					
						$active_members_count = count( get_field('active_members') );
						$active_members_years = get_field('years');
					
						$j = 0;
						while ( have_rows('active_members') ) : the_row();
								
							$active_members_name = get_sub_field('name');
							
							//Store the list
							$active_members_info[$j] .= $active_members_name . '<br>';
					 
						endwhile;
					
					endif;
					
					// Sustaining Members
					if( have_rows('sustaining_members') ):
					
						$sustaining_members_count = count( get_field('sustaining_members') );
						$sustaining_members_years = get_field('years');
					
						$j = 0;
						while ( have_rows('sustaining_members') ) : the_row();
								
							$sustaining_members_name = get_sub_field('name');
							
							//Store the list
							$sustaining_members_info[$j] .= $sustaining_members_name . '<br>';
					 
						endwhile;
					
					endif;
					
					// Past Presidents
					if( have_rows('past_presidents') ):
					
						while ( have_rows('past_presidents') ) : the_row();
	 
							$past_presidents_name = get_sub_field('name');
							$past_presidents_date = get_sub_field('date');
							
							//Store the list
							$past_presidents_info[0] .= '<div class="lc_row"><div class="lc_col pres"><p>'.$past_presidents_name.'</p></div><div class="lc_col pres"><p>'.$past_presidents_date.'</p></div></div>';
					 
						endwhile;
					
					endif;
					
					//Build the table
					echo '<div id="auxiliary">';
						echo '<div class="lc_row">';
							echo '<div class="lc_col">';
								echo '<strong>Officers</strong>';
								echo '<p>'.$officer_info.'</p>';
								echo '<strong>'.$active_members_years.' Active Members</strong>';
								echo '<p>'.$active_members_info[0].'</p>';
							echo '</div>';
							echo '<div class="lc_col">';
								echo '<strong>Standing Committees</strong>';
								echo '<p>'.$standing_committees_info.'</p>';
								echo '<strong>'.$sustaining_members_years.' Sustaining Members</strong>';
								echo '<p>'.$sustaining_members_info[0].'</p>';
							echo '</div>';
						echo '</div>';
		
						echo '<div class="lc_row">';
							echo '<div class="lc_col"><strong>Past Presidents</strong></div>';
						echo '</div>';
						echo $past_presidents_info[0];
		
					echo '</div>';
					
					/* Restore original Post Data */
					wp_reset_postdata();

				endwhile;

			endif;
		?>

	</div><!-- #content -->

<?php
get_footer();
