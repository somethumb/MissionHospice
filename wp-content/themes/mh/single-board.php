<?php
/**
 * The board profile template file
 */

get_header(); ?>
	<div id="content">

		<h1><?php 
		$name = explode(", ", get_the_title());
		$firstname = array_pop($name);
		$lastname = implode(" ", $name); 
		$position = get_field('position');
		if ($position)
			$position = ", " . $position;
		echo $firstname . " " . $lastname . $position; ?></h1>

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
