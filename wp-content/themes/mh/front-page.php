<?php
/**
 * The home page template file
 */

get_header(); ?>
	<?php the_slideshow(); ?>
	<div id="content" class="site-content" role="main">

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();
					
					the_content();
					
				endwhile;

			endif;
		?>

	</div><!-- #content -->
<?php
get_footer();
