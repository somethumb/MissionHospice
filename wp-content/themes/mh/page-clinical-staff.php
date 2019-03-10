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
					
					// Dwight Wilson first - members Query
					$args = array(
						'post_type' => 'staff',
						'tax_query' => array(
							array(
								'taxonomy' => 'stafftype',
								'field' => 'slug',
								'terms' => array( 'clinical-staff' )
							),
						),
						'orderby'	=> 'title',
						'order'		=> 'ASC',
						'p'	=> 17,
					);
					$dwilson_query = new WP_Query( $args );
					
					
					// The Staff members Query
					$args = array(
						'post_type' => 'staff',
						'tax_query' => array(
							array(
								'taxonomy' => 'stafftype',
								'field' => 'slug',
								'terms' => array( 'clinical-staff' )
							),
						),
						'orderby'	=> 'title',
						'order'		=> 'ASC',
						'posts_per_page'	=> -1
					);
					$staff_query = new WP_Query( $args );
					
					//print_r($staff_query);
					
					// The Loop
					if ( $staff_query->have_posts() ) {
						echo '<ul id="staff">';
							//Show Dwight Wilson first
							echo '<li id="stfid-'.$dwilson_query->post->ID.'" class="first">';
							//Get Member image
							$member_image = get_field('member_image', $dwilson_query->post->ID);
							if (!empty($member_image)) {
								$staff_image = '<div class="img"><img src="' . $member_image['sizes']['staff'] . '" alt="' . $member_image['alt'] . '" /></div>';
							} else {
								$staff_image = '<div class="img"><img src="'.site_url().'/wp-content/uploads/pic_staff.jpg" alt="Staff Member Photo" /></div>';
							}
							//Get Name reverse First Last
							$name = explode(", ", $dwilson_query->post->post_title);
							$firstname = array_pop($name);
							$lastname = implode(" ", $name); 
							//Get Credential
							$credential = get_field('credential', $dwilson_query->post->ID);
							if ($credential)
								$credential = ", " . $credential;
							$fullname = '<p>' . $firstname . " " . $lastname . $credential . '</p>';
							//Get Position
							$position = get_field('position', $dwilson_query->post->ID);
							if ($position)
								$position = '<cite>' . $position . '</cite>';
							//Get Email Address
							$email_address = get_field('email_address', $dwilson_query->post->ID);
							if ($email_address || $dwilson_query->post->post_content != '')
								$contact = '<div class="cnt">';
							//if ($email_address)
								//$contact .= '<a href="mailto:'.$email_address.'">Email</a>';
							if ($dwilson_query->post->post_content != '')
								$contact .= '<!-- | --><a href="'.get_permalink($dwilson_query->post->ID).'">Profile</a>';
							if ($email_address || $dwilson_query->post->post_content != '')
								$contact .= '</div>';
							//Display it
							echo $staff_image . '<div class="txt">' . $fullname . $position . $contact . '</div>';
							echo '</li>';
							$cnt = 2;
							while ( $staff_query->have_posts() ) {
								$cls = '';
								if ($cnt == 5)
									$cnt = 1;
								if ($cnt == 1)
									$cls = "first";
								$staff_query->the_post();
								if ($staff_query->post->ID != 17) { //Dwight Wilson
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
									//Get Credential
									$credential = get_field('credential');
									if ($credential)
										$credential = ", " . $credential;
									$fullname = '<p>' . $firstname . " " . $lastname . $credential . '</p>';
									//Get Position
									$position = '';
									$position = get_field('position');
									if ($position)
										$position = '<cite>' . $position . '</cite>';
									//Get Email Address
									$email_address = ''; $contact = '';
									$email_address = get_field('email_address');
									if ($email_address || $staff_query->post->post_content != '')
										$contact = '<div class="cnt">';
									//if ($email_address)
										//$contact .= '<a href="mailto:'.$email_address.'">Email</a>';
									if ($staff_query->post->post_content != '')
										$contact .= '<!-- | --><a href="'.get_permalink($staff_query->post->ID).'">Profile</a>';
									if ($email_address || $staff_query->post->post_content != '')
										$contact .= '</div>';
									//Display it
									echo $staff_image . '<div class="txt">' . $fullname . $position . $contact . '</div>';
									echo '</li>';
									$cnt++;
								}
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
