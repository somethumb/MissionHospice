<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="ctnr">
	<div id="top">
		<div id="hdr">
			<div id="tgl"><em class="menu-toggle"></em><span>Menu</span></div>
			<div id="navm">
				<?php wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navmp', 'container' => false, 'depth' => 2, 'menu_id' => 'menu-main-nav-m' ) ); ?>
				<?php wp_nav_menu( array( 'menu' => 'Top Nav', 'menu_class' => 'navmt', 'container' => false, 'menu_id' => 'menu-top-nav-m' ) ); ?>
			</div>			
			<div id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span id="logo-inner"><?php bloginfo( 'name' ); ?></span></a></div>
			<div id="dnte" style="background-image:url(<?php header_image(); ?>);"><a href="<?php echo get_permalink(1332); ?>">Donate</a></div>
			<div id="navt">
				<?php wp_nav_menu( array( 'menu' => 'Top Nav', 'menu_class' => 'navt', 'container' => false ) ); ?>
			</div>
			<div id="srch">
				<?php get_search_form(); ?>
			</div>
		</div>
		<div id="dntem"><a href="<?php echo get_permalink(1332); ?>">Donate</a></div>
		<div id="navp">
			<?php wp_nav_menu( array( 'menu' => 'Main Nav', 'menu_class' => 'navp sf-menu', 'container' => false, 'depth' => 2 ) ); ?>
		</div>
	</div>
	<div id="main">
		<div id="cols">
			<div id="sbar">
				<?php get_sidebar(); ?>
			</div>
			<div id="ctnt">