<?php
/**
 * The front page (home) template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>
	<?php the_slideshow(); ?>
	<div id="content" class="site-content" role="main">

		<h1><?php echo get_the_title(118); ?></h1>

		<?php if ( have_posts() ) : ?>

			<?php
			
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

			endwhile;
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</div><!-- #content -->

<?php
get_footer();
