<?php
/**
 * The template for displaying the We Are Mission Hospice page
 Template Name: We Are Mission Hospice
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
					
					//Build the table
					if( have_rows('videos') ):
						
						echo '<ul id="wearemh">';
					
							while ( have_rows('videos') ) : the_row();

								$video = get_sub_field('video');
								$thumbnail_caption = get_sub_field('thumbnail_&_caption');
		
								//var_dump($thumbnail_caption);

								echo '<li><a href="'.$video.'" class="youtube">'.wp_get_attachment_image($thumbnail_caption["id"], "Slideshow").'</a><span class="wp-caption-text">'.$thumbnail_caption["caption"].'</span></li>';

							endwhile;
		
						echo '</ul>';
					
					endif;
						
					/* Restore original Post Data */
					wp_reset_postdata();

				endwhile;

			endif;
		?>

	</div><!-- #content -->

<?php
get_footer();
