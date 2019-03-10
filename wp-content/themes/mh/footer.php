<?php
/**
 * The template for displaying the footer.
 */
?>
			</div>
		</div>
	</div>
	<div id="ftr">
    <div id="sig">
      <?php gravity_form( 7, false, true, false, null, true ); ?>
    </div>
		<div id="info">
			<ul>
				<li id="addr"><em>Offices</em>1670 South Amphlett Blvd.<span>Suite 300, San Mateo, CA 94402</span></li>
				<li id="gmap"><a href="https://www.google.com/maps/place/Mission+Hospice+%26+Home+Care/@37.558984,-122.3053487,17z/data=!3m1!4b1!4m5!3m4!1s0x808f9e599d136ab9:0x5ed7dca50536932d!8m2!3d37.558984!4d-122.30316" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i>Locate us on Google Maps</a></li>
				<li><span>P</span> <a href="tel:+1-650-554-1000">650.554.1000</a></li>
				<li><span>F</span> <a href="tel:+1-650-554-1001">650.554.1001</a></li>
				<?php wp_nav_menu( array( 'menu' => 'Footer Nav', 'menu_class' => 'navf', 'menu_id' => 'navf', 'container' => false, 'items_wrap' => '%3$s' ) ); ?>
				<li class="menu-item"><?php wp_loginout(); ?></li>
			</ul>
			<?php wp_nav_menu( array( 'menu' => 'Social Media', 'menu_class' => 'scl', 'menu_id' => 'scl', 'container' => false ) ); ?>
		</div>
		<div id="msthd">
			<ul>
				<li>&copy; <?php echo date("Y") ?> Mission Hospice &amp; Home Care</li>
				<li><a href="http://www.somethumb.com/" target="_blank" title="Somethumb Web Design + Development">Site by Somethumb</a></li>
			</ul>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>