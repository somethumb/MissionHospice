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
					
					mh_newsletters();
					
					//echo do_shortcode('[gravityform id="7" name="Newsletter" ajax="true"]');

				endwhile;

			endif;
			
			//Newsletters
			function mh_newsletters() {
					
				if( have_rows('newsletter') ):
				
					echo '<div id="newsletters">';
					
					$repeater = get_field('newsletter'); 
							
					foreach( $repeater as $key => $row ) {
						$column_date[ $key ] = $row['date'];
					}
					//Sort by date
					array_multisort( $column_date, SORT_DESC, $repeater );
					
					$groupedArray = array();
					foreach($repeater as $key => $value)
					{
						$year = date('Y', strtotime($value['date']));
						$groupedArray[$year][] = $value;
					}
					//Create Years array and get items for each year
					foreach( $groupedArray as $key => $value ) {
						echo '<h2>'.$key.' newsletters</h2>';	
						echo '<ul>';
						foreach( $value as $key => $row ) { 
							$date = DateTime::createFromFormat('Ymd', $row['date']);
							$image = $row['image'];
							$thumb = $image['sizes']['Newsletter'];
							$doc = $row['document']; ?>
							<li>
							<?php if( $doc ): ?>
								<a href="<?php echo $doc; ?>" target="_blank">
							<?php endif; ?>
				 
								<img src="<?php echo $thumb; ?>" alt="<?php echo $image['alt']; ?>" />
				 
							<?php if( $doc ): ?>
								</a>
							<?php endif; ?>
				 			<h3><?php echo $date->format('F Y'); ?></h3>
							</li>
							<?php
						}
						echo '</ul>';
					}
					
					echo '</div>';
			
				endif; //have_rows('newsletter')
				
			}
		?>

	</div><!-- #content -->
<?php
get_footer();
