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
					
					// The Patients Stories Query
					$args = array(
						'post_type' => 'patientstory',
						'orderby'	=> 'menu_order',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$story_query = new WP_Query( $args );
					
					//print_r($story_query);
					
					// The Loop
					if ( $story_query->have_posts() ) {
						echo '<ul id="story">';
							$cnt = 1;
							while ( $story_query->have_posts() ) {
								$cls = '';
								if ($cnt == 3)
									$cnt = 1;
								if ($cnt == 1)
									$cls = "first";
								$story_query->the_post();
								echo '<li id="stfid-'.$story_query->post->ID.'" class="'.$cls.'">';
								//Get Member image
								$staff_image = '';
								$member_image = get_the_post_thumbnail($story_query->post->ID,'Slideshow');
								if (!empty($member_image)) {
									$staff_image = '<div class="img"><a href="'.get_permalink().'">' . $member_image . '</a></div>';
								} else {
									$staff_image = '<div class="img"><a href="'.get_permalink().'"><img src="'.site_url().'/wp-content/uploads/pic_stories.jpg" alt="Patients Stories Photo" /></a></div>';
								}
								echo $staff_image . '<a href="'.get_permalink().'">'.get_the_title().'</a>';
								echo '</li>';
								$cnt++;
							}
						echo '</ul>';
					} else {
						// no posts found
					}
					/* Restore original Post Data */
					wp_reset_postdata();

				endwhile;

			endif;
		?>

	</div><!-- #content -->

<?php
get_footer();
