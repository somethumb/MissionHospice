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
					
					// Officers Query
					$args = array(
						'post_type' => 'board',
						'tax_query' => array(
							array(
								'taxonomy' => 'boardtype',
								'field' => 'slug',
								'terms' => array( 'officers' )
							),
						),
						'orderby'	=> 'menu_order',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$staff_query = new WP_Query( $args );
					
					mh_display_board($staff_query);
					
					// Members Query
					$args = array(
						'post_type' => 'board',
						'tax_query' => array(
							array(
								'taxonomy' => 'boardtype',
								'field' => 'slug',
								'terms' => array( 'members' )
							),
						),
						'orderby'	=> 'title',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$staff_query = new WP_Query( $args );
					
					mh_display_board($staff_query);
					
					// Lifetime Member Query
					$args = array(
						'post_type' => 'board',
						'tax_query' => array(
							array(
								'taxonomy' => 'boardtype',
								'field' => 'slug',
								'terms' => array( 'honorary-lifetime-member' )
							),
						),
						'orderby'	=> 'title',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$staff_query = new WP_Query( $args );
					
					mh_display_board($staff_query);
					
					// Co Founder Query
					$args = array(
						'post_type' => 'board',
						'tax_query' => array(
							array(
								'taxonomy' => 'boardtype',
								'field' => 'slug',
								'terms' => array( 'mission-hospice-co-founder' )
							),
						),
						'orderby'	=> 'title',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$staff_query = new WP_Query( $args );
					
					mh_display_board($staff_query);
					
				endwhile;

			endif;
			
			function mh_display_board($staff_query) {
				// The Loop
				if ( $staff_query->have_posts() ) {
					$taxname = get_term_by('slug', $staff_query->query_vars['term'], 'boardtype');
					echo '<h2>'.$taxname->name.'</h2>';
					//echo '<h2>'.$terms[0]->name.'</h2>';
					echo '<ul id="staff">';
						$cnt = 1;
						while ( $staff_query->have_posts() ) {
							$cls = '';
							if ($cnt == 5)
								$cnt = 1;
							if ($cnt == 1)
								$cls = "first";
							$staff_query->the_post();
							echo '<li id="stfid-'.$staff_query->post->ID.'" class="'.$cls.'">';
							//Get Member image
							$staff_image = '';
							$member_image = get_field('member_image');
							if (!empty($member_image)) {
								$staff_image = '<div class="img"><img src="' . $member_image['sizes']['staff'] . '" alt="' . $member_image['alt'] . '" /></div>';
							} else {
								$staff_image = '<div class="img"><img src="'.site_url().'/wp-content/uploads/pic_staff.jpg" alt="Staff Member Photo" /></div>';
							}
							//Get Name reverse First Last
							$fullname = '';
							$name = explode(", ", $staff_query->post->post_title);
							$firstname = array_pop($name);
							$lastname = implode(" ", $name); 
							$fullname = '<p>' . $firstname . " " . $lastname . '</p>';
							//Get Position
							$position = '';
							$position = get_field('position');
							if ($position)
								$position = '<cite>' . $position . '</cite>';
							//Get Bio
							$bio = '';
							$bio = get_field('bio');
							if ($bio)
								$bio = '<div class="bio">' . $bio . '</div>';
							//Get Profile
							$contact = '';
							if ($staff_query->post->post_content != '')
								$contact = '<div class="cnt"><a href="'.get_permalink($staff_query->post->ID).'">Profile</a></div>';
							//Display it
							echo $staff_image . '<div class="txt">' . $fullname . $position . $bio . $contact . '</div>';
							echo '</li>';
							$cnt++;
						}
					echo '</ul>';
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
