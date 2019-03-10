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
					
					mh_annualreports();

				endwhile;

			endif;
			
			//Newsletters
			function mh_annualreports() {
					
				if( have_rows('annual_report') ):
				
					echo '<div id="annual_reports">';
					
						echo '<ul>';
						
						$repeater = get_field('annual_report'); 
								
						foreach( $repeater as $key => $row ) {
							$column_date[ $key ] = $row['date'];
						}
						//Sort by date
						array_multisort( $column_date, SORT_DESC, $repeater );
						
						foreach($repeater as $key => $row)
						{
							$year = date('Y', strtotime($row['date']));
							//Create Years array and get items for each year
							$date = DateTime::createFromFormat('Ymd', $row['date']);
							$image = $row['image'];
							$thumb = $image['sizes']['Newsletter'];
							$doc = $row['report'];
							$audit = $row['audit']; ?>
							<li>
							<h2><?php echo $year.' Annual Report'; ?></h2>
							<?php if( $doc ): ?>
								<a href="<?php echo $doc; ?>" target="_blank">
							<?php endif; ?>
							
								<img src="<?php echo $thumb; ?>" alt="<?php echo $image['alt']; ?>" />
								
							<?php if( $doc ): ?>
								</a>
							<?php endif; ?>
				 
				 			<?php if( $doc ): ?>
								<a href="<?php echo $doc; ?>" target="_blank">Annual Report</a>							
								<?php if( $audit ): ?>
									 | <a href="<?php echo $audit; ?>" target="_blank">Audit</a>
								<?php endif; ?>
							<?php endif; ?>
							
							</li>
							<?php
						}
						echo '</ul>';
					
					echo '</div>';
			
				endif; //have_rows('newsletter')
				
			}
		?>

	</div><!-- #content -->
<?php
get_footer();
