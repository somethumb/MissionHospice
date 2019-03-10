<?php
/**
 * The staff profile template file
 */

get_header(); ?>
	<div id="content">

		<h1><?php 
		$name = explode(", ", get_the_title());
		$firstname = array_pop($name);
		$lastname = implode(" ", $name); 
		$credential = get_field('credential');
		if ($credential)
			$credential = ", " . $credential;
		echo $firstname . " " . $lastname . $credential; ?></h1>

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
