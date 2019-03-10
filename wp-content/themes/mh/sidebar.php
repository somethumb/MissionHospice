<?php 
if ('staff' == $post_type) { //Display Sub Menu for Staff post type
	wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navs', 'submenu' => 'Our team', 'container' => false ) ); 
} elseif ('patientstory' == $post_type || is_single() || is_archive()) { //Display Sub Menu for Patients Stories post type
	wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navs', 'submenu' => 'For patients & families', 'container' => false ) );
} elseif (is_page(1226)) { //Display Sub Menu for Donation Thank You
	wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navs', 'submenu' => 'Donate', 'container' => false ) );
} elseif (is_page(506)) { //Display Sub Menu for Photo Gallery
	wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navs', 'submenu' => 'Events & news', 'container' => false ) );
} else { //Display Sub Menu from parent (if on a page which has submenu)
	wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navs', 'sub_menu' => true, 'container' => false ) );
}
?>

<?php 	/* Widgetized sidebar, if you have the plugin installed. */
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
endif;
?>