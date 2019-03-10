<?php
/**
 * The Newsletters template file
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
					
					mh_partners();
					
					mh_consultants();

				endwhile;

			endif;
			
			//Newsletters
			function mh_partners() {
					
				if( have_rows('partners') ):
				
					echo '<div id="partners">';
					
					//Create Years array and get items for each year
					while ( have_rows('partners') ) : the_row();
						echo '<h2>'.the_sub_field('name').', '.the_sub_field('position').'</h2>';
						$image = get_sub_field('image');
						the_sub_field('bio');
					endwhile;
					
					echo '</div>';
			
				endif; //have_rows('newsletter')
				
			}
		?>

	</div><!-- #content -->
<?php
get_footer();
