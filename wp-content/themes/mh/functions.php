<?php
/**
 * functions and definitions.
 */
// Remove toolbar
add_filter('show_admin_bar', '__return_false');

// Disable auto core update email notification
add_filter( 'auto_core_update_send_email', '__return_false' );

/**
 * Sets up theme defaults
 */
function mh_setup() {

	// Add Menus support
	add_theme_support( 'menus' );

	// Add Featured Image support
	add_theme_support( 'post-thumbnails' );

	// Add Custom Header
	$args = array(
		'width'         => 1020,
		'height'        => 120,
		'header-text'   => false,
	);
	add_theme_support( 'custom-header', $args );
	
	// HTML5 Searchform
	add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'mh_setup' );

//add_image_size( 'inv-display-image', '650', '225', false );

/**
 * Enqueues scripts and styles for front-end.
 */
function mh_scripts_styles() {
	global $wp_version;
	
	// Load Reset css
	wp_enqueue_style( 'reset-style', get_stylesheet_directory_uri() . '/cssreset-min.css', false, '3.14.1' );

	// Load Google Fonts
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Serif:400,700|Noto+Sans:400,700' );
			
	// Load font awesome
	wp_enqueue_script(
		'fopnt-awesome-script',
		'https://use.fontawesome.com/ef737c0805.js'
	);
	
	// Loads superfish scrips and styles for dropdown menus
	wp_enqueue_style( 
		'superfish-style', 
		get_stylesheet_directory_uri() . '/css/superfish.css'
	);		
	wp_enqueue_script(
		'superfish-script',
		get_stylesheet_directory_uri() . '/js/superfish.min.js',
		array('jquery', 'jquery-ui-core')
	);
			
	// Load jCycle 2
	wp_enqueue_script(
		'jcycle2-script',
		'//malsup.github.io/min/jquery.cycle2.min.js',
		array('jquery'),
		'2.1.6'
	);
	
	// UI Theme
	wp_enqueue_style( 
		'jquery-ui-style', 
		get_stylesheet_directory_uri() . '/css/jquery-ui.min.css'
	);
	
	// Load youtube popup on desktop
	if ( wpmd_is_notphone() ) :
		wp_enqueue_style( 'youtubepopup-style', get_stylesheet_directory_uri() . '/css/YouTubePopUp.css', false, $wp_version );
		wp_enqueue_script( 'youtubepopup-script', get_stylesheet_directory_uri() . '/js/jquery.youtubepopup.min.js', array('jquery', 'jquery-ui-dialog'), '2.4' );
		wp_add_inline_script( 'youtubepopup-script', 'jQuery(function () {"use strict";	if (jQuery("a.youtube")[0]) { jQuery("a.youtube").YouTubePopUp(); } });' );
	endif;
		
}
add_action( 'wp_enqueue_scripts', 'mh_scripts_styles' );

// Enqueue main styles at highest priority for front-end.
function mh_main_scripts_styles() {
	global $wp_version, $post;
	
	// Load main scripts
	wp_enqueue_script( 'main-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), $wp_version.'.20131107' );
	
	// Load main stylesheet
	wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/style.css', false, $wp_version.'.20170822' );
	
	// Load tablet stylesheet
	wp_enqueue_style( 'tablet-style', get_stylesheet_directory_uri() . '/style-tablet.css', array('main-style'), $wp_version.'.20170822', 'only screen and (max-width: 1020px)' );

		// Load mobile stylesheet
		wp_enqueue_style( 'mobile-style', get_stylesheet_directory_uri() . '/style-mobile.css', array('main-style'), $wp_version.'.20170822', 'only screen and (max-width: 782px)' );
	
}
add_action( 'wp_enqueue_scripts', 'mh_main_scripts_styles', 999 );

// Register sidebars
function mh_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'mh_widgets_init' );

// Add sidebar manager for these post types
add_post_type_support( 'board', 'woosidebars' );
add_post_type_support( 'staff', 'woosidebars' );

add_filter( 'wp_editor_settings', 'remove_editor_quicktags', 10, 2 );
function remove_editor_quicktags( $settings, $id ){
    // $id will be 'content' in your example
    // use it in an if or make it gone for everything...

    // use $pagenow to determine if you are on the edit comments page.
    global $pagenow; 
    if ( $pagenow === 'widgets.php' ){
        $settings['quicktags'] = false;
    }
    return $settings;
}

// Responsive embeded videos
add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);
function wrap_embed_with_div($html, $url, $attr) {
	return "<div class=\"responsive-container\">".$html."</div>";
}

// Change the length of the excerpt number of words, and link to more on the A1C events
add_filter( 'excerpt_length', 'a1c_excerpt_length');
function a1c_excerpt_length() {
	if ( get_post_type() == 'ai1ec_event' )
    return 25;
}
add_filter( 'excerpt_more', 'a1c_excerpt_more' );
function a1c_excerpt_more() {
  global $post;
	if ( get_post_type() == 'ai1ec_event' )
    return ' [<a href="'.get_permalink($post->ID).'">more</a>]';
}

// Add to content
add_filter( 'the_content', 'stc_the_content_filter' );
function stc_the_content_filter($content) {	
  ob_start();
  call_user_func('stc_get_content', get_the_ID());
  return $content . ob_get_clean();
} // END

// Gets the content based the_content filter
function stc_get_content($content_id) { 
  switch ($content_id) {

    case 9776:
      $url = "https://us15.campaign-archive.com/feed?u=cfdcccc39d0e14f773117132c&id=c4b81c4480";

      $rss = new DOMDocument();
      $rss->load($url);
      $feed = array();
      foreach ($rss->getElementsByTagName('item') as $node) {
          $item = array ( 
              'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
              'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
              'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
              'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
              );
          array_push($feed, $item);
      }
      $limit = 1;
      for($x=0;$x<$limit;$x++) {
          $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
          $link = $feed[$x]['link'];
          $description = $feed[$x]['desc'];
          $tags = array('html','head','meta','!doctype','body');
          foreach($tags as $tag) {
            $description = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", '', $description);
          }
          $date = date('l F d, Y', strtotime($feed[$x]['date']));
          echo '<p><strong>'.$title.'</strong><br />';
          echo '<small><em>Posted on '.$date.'</em></small></p>';
          echo $description;
      }
      ?>
      <style type="text/css">
        table.mcnTextContentContainer, table.mcnTextBlock, table#canspamBarWrapper {
          display: none;
        }
      </style>
      <?php
    break;

  } //
}

function the_slideshow() {
	global $post;
	if( have_rows('slides') ) { 
	$slides = get_field('slides');
	$slide_count = count($slides);
	if ($slide_count > 1) {
		$randomslide =  array_rand($slides, $slide_count); 
		shuffle($randomslide);
	} else {
		$randomslide = array_keys($slides);
	}	 
	?>
	<div id="sld">
		<?php if ( wpmd_is_notphone() ) : ?>
			<div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="6000" data-cycle-auto-height="container">
				<?php foreach ($randomslide as $field):

					// vars
					$image = $slides[$field]['image'];
					$testimonial = $slides[$field]['testimonial'];
					$author = $slides[$field]['author'];

					?>
					<div class="sld_ctnr">
						<?php if($image) { ?>
						<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $testimonial; ?>">
						<div class="sld_ctnt"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
						<?php } else { ?>
						<div class="sld_ctnt full"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
						<?php } ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<?php foreach ($randomslide as $field):

				// vars
				$image = $slides[$field]['image'];
				$testimonial = $slides[$field]['testimonial'];
				$author = $slides[$field]['author'];

				?>
				<div class="sld_ctnr">
					<?php if($image) { ?>
					<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $testimonial; ?>">
					<div class="sld_ctnt"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
					<?php } else { ?>
					<div class="sld_ctnt full"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
					<?php } ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div> 
	<?php 
	}
}

//Change title text for Board Members and Staff Members CPT
function mh_custom_admin_enter_title( $input ) {
	global $post_type;

	if ( is_admin() && ('board' == $post_type || 'staff' == $post_type) )
		return __( 'Enter name here' );

	return $input;
}
add_filter( 'enter_title_here', 'mh_custom_admin_enter_title' );

// Display sub menu items of the wp_nav_menu - i.e. 'sub_menu' => true
add_filter( 'wp_nav_menu_objects', 'mh_wp_nav_menu_objects_sub_menu', 10, 2 );
function mh_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
if ( isset( $args->sub_menu ) ) {
	$root_id = 0;
	// find the current menu item
	foreach ( $sorted_menu_items as $menu_item ) {
		if ( $menu_item->current ) {
			// set the root id based on whether the current menu item has a parent or not
			$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
			break;
		}
	}
	// find the top level parent
	if ( ! isset( $args->direct_parent ) ) {
		$prev_root_id = $root_id;
		while ( $prev_root_id != 0 ) {
			foreach ( $sorted_menu_items as $menu_item ) {
				if ( $menu_item->ID == $prev_root_id ) {
				$prev_root_id = $menu_item->menu_item_parent;
				// don't set the root_id to 0 if we've reached the top of the menu
				if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
				break;
				}
			}
		}
	}
 
	$menu_item_parents = array();
	foreach ( $sorted_menu_items as $key => $item ) {
		// init menu_item_parents
		if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
			 
			if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
				// part of sub-tree: keep!
				$menu_item_parents[] = $item->ID;
			} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
				// not part of sub-tree: away with it!
				unset( $sorted_menu_items[$key] );
			}
		}
		return $sorted_menu_items;
	} else {
		return $sorted_menu_items;
	}
}

// Display sub menu items of specific parent id in wp_nav_menu - i.e. 'submenu' => 'Our Team'
add_filter( 'wp_nav_menu_objects', 'mh_submenu_limit', 10, 2 );
function mh_submenu_limit( $items, $args ) {

    if ( empty($args->submenu) )
        return $items;

    $parent_id = array_pop( wp_filter_object_list( $items, array( 'title' => $args->submenu ), 'and', 'ID' ) );
    $children  = submenu_get_children_ids( $parent_id, $items );

    foreach ( $items as $key => $item ) {

        if ( ! in_array( $item->ID, $children ) )
            unset($items[$key]);
    }

    return $items;
}
function submenu_get_children_ids( $id, $items ) {
    $ids = wp_filter_object_list( $items, array( 'menu_item_parent' => $id ), 'and', 'ID' );
    foreach ( $ids as $id ) {

        $ids = array_merge( $ids, submenu_get_children_ids( $id, $items ) );
    }
    return $ids;
}

// Add radio button (single) choice for taxonomies - must use Radio Buttons for Taxonomies plugin
add_filter( "radio-buttons-for-taxonomies-no-term-tribe_events_cat", "__return_FALSE" ); 

class GF_Init { 
	
	/** @var object Class Instance */
	private static $instance;

	/**
	 * Get the class instance
	 */
	public static function get_gf_instance() {
		return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'gf_wp_functions' ), 1 );
		add_action( 'admin_init', array( $this, 'gf_admin_init_functions' ) );
	}
	
	// These functions will run on the client side
	public function gf_wp_functions() {

    // Move GF scripts to the footer
    add_filter( 'gform_init_scripts_footer', '__return_true' );

    // Add visibility to GF
    add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );
    
		// Change validation message - Newsletter
		add_filter( 'gform_validation_message_7', 'stc_validation_message_7', 10, 2 );
		function stc_validation_message_7( $message, $form ) {
			//break;
			return "<div class='validation_error'>Your Full Name, Email Address and Zip Code are required.</div>";
		}
		// Spinner
		add_filter( 'gform_ajax_spinner_url', 'stc_ajax_spinner_url', 10, 2 );
		function stc_ajax_spinner_url( $image_src, $form ) { 
			return get_stylesheet_directory_uri() . '/images/Disk.svg';
		}
		
		// Add events to payment feeds so we can process forms if paid or failed, etc.
		/* Note: The ability to assign notifications to be sent on payment events is now a built-in feature of Gravity Forms Authorize.net Add-On 2.1.4+, Gravity Forms PayPal Standard Add-On 2.6+, and Gravity Forms Stripe Add-On 2.0+ when running Gravity Forms 1.9.12+. For those running these versions the following code snippets are no longer required.
		add_filter( 'gform_notification_events', function ( $notification_events, $form ) {
				$has_stripe_feed            = function_exists( 'gf_stripe' ) ? gf_stripe()->get_feeds( $form['id'] ) : false;
				$has_paypal_feed            = function_exists( 'gf_paypal' ) ? gf_paypal()->get_feeds( $form['id'] ) : false;
				$has_paypalpaymentspro_feed = function_exists( 'gf_paypalpaymentspro' ) ? gf_paypalpaymentspro()->get_feeds( $form['id'] ) : false;
				$has_authorizenet_feed      = function_exists( 'gf_authorizenet' ) ? gf_authorizenet()->get_feeds( $form['id'] ) : false;

				if ( $has_stripe_feed || $has_paypal_feed || $has_paypalpaymentspro_feed || $has_authorizenet_feed ) {
						$payment_events = array(
								'complete_payment'          => __( 'Payment Completed', 'gravityforms' ),
								'refund_payment'            => __( 'Payment Refunded', 'gravityforms' ),
								'fail_payment'              => __( 'Payment Failed', 'gravityforms' ),
								'add_pending_payment'       => __( 'Payment Pending', 'gravityforms' ),
								'void_authorization'        => __( 'Authorization Voided', 'gravityforms' ),
								'create_subscription'       => __( 'Subscription Created', 'gravityforms' ),
								'cancel_subscription'       => __( 'Subscription Canceled', 'gravityforms' ),
								'expire_subscription'       => __( 'Subscription Expired', 'gravityforms' ),
								'add_subscription_payment'  => __( 'Subscription Payment Added', 'gravityforms' ),
								'fail_subscription_payment' => __( 'Subscription Payment Failed', 'gravityforms' ),
						);

						return array_merge( $notification_events, $payment_events );
				}

				return $notification_events;
		}, 10, 2 );
		*/

		// Take action!
		/*add_action( 'gform_post_payment_action', function ( $entry, $action ) {
				$form = GFAPI::get_form( $entry['form_id'] );
				GFAPI::send_notifications( $form, $entry, rgar( $action, 'type' ) );
		}, 10, 2 );*/

		// Number of Guests 2018 Celebration form
		add_filter("gform_pre_render_16", "mh_guests_options_16");
		function mh_guests_options_16($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				$quantity_field_id = 4;
        $input_html_id = '#input_'.$form['id'].'_' . $quantity_field_id;
            ?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		} //
		
		
		// Validate quantity field
		add_filter("gform_field_validation_1_31", "mh_quantity_validation", 10, 4);
		function mh_quantity_validation($result, $value, $form, $field){
			if(intval($value) != $value) {
				$result["message"] = __("Please enter a whole dollar amount.", "gravityforms");
			}
			return $result;
		}
		
		/*Meal Options*/
		// Get the meal options and run the class below
		add_filter("gform_pre_render_10", "mh_guest_meal_options_10_22");
		function mh_guest_meal_options_10_22($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				switch (rgpost('input_3')) {
					case "1|150":
						$input_html_id = '#input_10_4';
						break;
					case "2|1500":
						$input_html_id = '#choice_10_3_3';
						break;
					case "4|2500":
						$input_html_id = '#choice_10_3_2';
						break;
					case "10|5000":
						$input_html_id = '#choice_10_3_3';
						break;
					case "20|10000":
						$input_html_id = '#choice_10_3_4';
						break;
					case "20|20000":
						$input_html_id = '#choice_10_3_4';
						break;
				}
						?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		}

		// Get the meal options and run the class below
		add_filter("gform_pre_render_13", "mh_guest_meal_options_13_22");
		function mh_guest_meal_options_13_22($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				switch ( substr(rgpost('input_3'), 0, 2) ) {
					case "1|":
						$input_html_id = '#input_13_4';
						break;
				}
						?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		}
		
		// Get the meal options and run the class below
		add_filter("gform_pre_render_14", "mh_guest_meal_options_14_22");
		function mh_guest_meal_options_14_22($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				switch (rgpost('input_3')) {
					case "1|150":
						$input_html_id = '#input_14_4';
						break;
					case "10|1500":
						$input_html_id = '#choice_14_3_1';
						break;
					case "2|1000":
						$input_html_id = '#choice_14_3_2';
						break;
					case "4|2500":
						$input_html_id = '#choice_14_3_3';
						break;
					case "10.1|5000":
						$input_html_id = '#choice_14_3_4';
						break;
					case "10.2|10000":
						$input_html_id = '#choice_14_3_5';
						break;
					case "20|25000":
						$input_html_id = '#choice_14_3_6';
						break;
				}
						?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		}
		/*end Meal Options*/
		
		// Get the meal options and run the class below
		add_filter("gform_pre_render_12", "mh_guest_meal_options_12_22");
		function mh_guest_meal_options_12_22($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				$quantity_field_id = 4;
        $input_html_id = '#input_'.$form['id'].'_' . $quantity_field_id;
						?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		}
		/*end Meal Options*/
		
		// Get the meal options and run the class below
		add_filter("gform_pre_render_17", "mh_guest_meal_options_17_22");
		function mh_guest_meal_options_17_22($form){
			if (!IS_ADMIN) {
				$current_page = GFFormDisplay::get_current_page($form["id"]);
			}
			// Start page 2
			if ($current_page == 2) {
				$list_field_id = 22;
				switch (rgpost('input_3')) {
					case "1|150":
						$input_html_id = '#input_17_4';
						break;
					case "10|1500":
						$input_html_id = '#choice_17_3_1';
						break;
					case "2|1000":
						$input_html_id = '#choice_17_3_2';
						break;
					case "4|2500":
						$input_html_id = '#choice_17_3_3';
						break;
					case "10.1|5000":
						$input_html_id = '#choice_17_3_4';
						break;
					case "10.2|10000":
						$input_html_id = '#choice_17_3_5';
						break;
					case "20|25000":
						$input_html_id = '#choice_17_3_6';
						break;
				}
						?>

						<style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $list_field_id; ?> .gfield_list_icons { display: none; } </style>

						<?php

				new GWAutoListFieldRows( array( 
					'form_id' => $form["id"],
					'list_field_id' => $list_field_id,
					'input_html_id' => $input_html_id
				) );

			}	
			return $form;
		}
    
		/*Meal Choices Forms*/
		//This filter declaration targets the 2nd column of the field whose id is 22 in form whose id is 10
		add_filter("gform_column_input_10_22_2", "change_column2_content", 10, 5);
		function change_column2_content($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => ",Mushroom Risotto,Swordfish Parmesan,Braised Short Ribs");
			}
		}
		//This filter declaration targets the 2nd column of the field whose id is 22 in form whose id is 13
		add_filter("gform_column_input_13_22_2", "change_column2_content_13_22_2", 10, 5);
		function change_column2_content_13_22_2($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => "Tournament bridge, Party bridge");
			}
		}
		//This filter declaration targets the 3rd column of the field whose id is 22 in form whose id is 13
		add_filter("gform_column_input_13_22_3", "change_column2_content_13_22_3", 10, 5);
		function change_column2_content_13_22_3($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => "Taco salad, Poached salmon salad, Vegetarian");
			}
		}
		//This filter declaration targets the 2nd column of the field whose id is 22 in form whose id is 14
		add_filter("gform_column_input_14_22_2", "change_column2_content_14_22_2", 10, 5);
		function change_column2_content_14_22_2($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => "Pan Seared Salmon, Braised Beef Short Ribs, Mushroom Risotto");
			}
		}
		//This filter declaration targets the 2nd column of the field whose id is 22 in form whose id is 12
		add_filter("gform_column_input_12_22_2", "change_column2_content_12_22_2", 10, 5);
		function change_column2_content_12_22_2($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => "Prime Rib, Sea Bass, Vegetarian");
			}
		}
		//This filter declaration targets the 2nd column of the field whose id is 22 in form whose id is 17
		add_filter("gform_column_input_17_22_2", "change_column2_content_17_22_2", 10, 5);
		function change_column2_content_17_22_2($input_info, $field, $text, $value, $form_id){
			//build field name, must match List field syntax to be processed correctly
			if (!IS_ADMIN) {
				$input_field_name = 'input_' . $field["id"] . '[]';
				$tabindex = GFCommon::get_tabindex();
				return array("type" => "select", "choices" => "Chicken Florentine, Braised Beef Short Ribs, Mushroom Risotto (V GF)");
			}
		}
		/*end Meal Choices*/
		
		// displays the product label instead of the value in the order summary (everywhere the order summary is displayed)
		add_filter( 'gform_product_info', 'my_show_product_labels_in_summary', 10, 3 );
		function my_show_product_labels_in_summary( $product_info, $form, $entry ) {

				remove_filter( 'gform_product_info', 'my_show_product_labels_in_summary', 10, 3 );

				$product_info = GFCommon::get_product_fields( $form, $entry, true );

				add_filter( 'gform_product_info', 'my_show_product_labels_in_summary', 10, 3 );

				return $product_info;
		}

		// displays the product label instead of the value on the entry list view
		add_filter( 'gform_entries_field_value', 'my_show_product_labels', 10, 4 );
		function my_show_product_labels( $value, $form_id, $field_id, $entry ) {

				$form = GFAPI::get_form( $form_id );
				$field = GFFormsModel::get_field( $form, $field_id );

				if( $field['type'] == 'product' && isset( $field['choices'] ) && is_array( $field['choices'] ) ) {
					$value = explode( '|', $entry[$field['id']] );
					$value = GFFormsModel::get_choice_text( $field, $value[0] );
				}

					return $value;
		}
		
	}
	
	// These functions will run in the admin side
	public function gf_admin_init_functions() { 
	}
	
}
GF_Init::get_gf_instance();
/* END Gravity Forms Functions */


/**
* Set Number of List Field Rows by Field Value
* http://gravitywiz.com/2012/06/03/set-number-of-list-field-rows-by-field-value/
*/
class GWAutoListFieldRows {
    
    private static $_is_script_output;
    
    function __construct( $args ) {
        
        $this->_args = wp_parse_args( $args, array( 
            'form_id'       => false,
            'input_html_id' => false,
            'list_field_id' => false
        ) );
        
        extract( $this->_args ); // gives us $form_id, $input_html_id, and $list_field_id
        
        if( ! $form_id || ! $input_html_id || ! $list_field_id )
            return;
        
        add_filter( 'gform_register_init_scripts', array( $this, 'register_init_script' ) );
        
        if( ! self::$_is_script_output )
            $this->output_script();
        
        return $form;
    }
    
    function register_init_script( $form ) {
        
        // remove this function from the filter otherwise it will be called for every other form on the page
        remove_filter( 'gform_register_init_scripts', array( $this, 'register_init_script' ) );
                
        $args = array(
            'formId'      => $this->_args['form_id'],
            'listFieldId' => $this->_args['list_field_id'],
            'inputHtmlId' => $this->_args['input_html_id']
            );
        
        $script = "new gwalfr(" . json_encode( $args ) . ");";
        $key = implode( '_', $args );
        
        GFFormDisplay::add_init_script( $form['id'], 'gwalfr_' . $key , GFFormDisplay::ON_PAGE_RENDER, $script );
        
    }
    
    function output_script() {
    ?>
        
		<script type="text/javascript">
            
        window.gwalfr;
        
        (function($){
        
            gwalfr = function( args ) {
                
                this.formId      = args.formId, 
                this.listFieldId = args.listFieldId, 
                this.inputHtmlId = args.inputHtmlId;
                
                this.init = function() {
                    
                    var gwalfr = this,
                        triggerInput = $( this.inputHtmlId );
                    
                    // update rows on page load
                    this.updateListItems( triggerInput, this.listFieldId, this.formId );
                    
                    // update rows when field value changes
                    triggerInput.change(function(){
                        gwalfr.updateListItems( $(this), gwalfr.listFieldId, gwalfr.formId );
                    });
                    
                }
                
                this.updateListItems = function( elem, listFieldId, formId ) {
                    
                    var listField = $( '#field_' + formId + '_' + listFieldId ),
                        count = parseInt( elem.val() );
                        rowCount = listField.find( 'table.gfield_list tbody tr' ).length,
                        diff = count - rowCount;
                    
                    if( diff > 0 ) {
                        for( var i = 0; i < diff; i++ ) {
                            listField.find( '.add_list_item:last' ).click();
                        }    
                    } else {
                        
                        // make sure we never delete all rows
                        if( rowCount + diff == 0 )
                            diff++;
                            
                        for( var i = diff; i < 0; i++ ) {
                            listField.find( '.delete_list_item:last' ).click();
                        }
                        
                    }
                }
                
                this.init();
                
            }
            
        })(jQuery);
        
		</script>
		
		<?php
    }
    
}

/**
* Require All Columns of List Field
* http://gravitywiz.com/require-all-columns-of-list-field/
*/
class GWRequireListColumns {

    private $field_ids;
    
    public static $fields_with_req_cols = array();

    function __construct($form_id = '', $field_ids = array(), $required_cols = array()) {

        $this->field_ids = ! is_array( $field_ids ) ? array( $field_ids ) : $field_ids;
        $this->required_cols = ! is_array( $required_cols ) ? array( $required_cols ) : $required_cols;
        
        if( ! empty( $this->required_cols ) ) {
            
            // convert values from 1-based index to 0-based index, allows users to enter "1" for column "0"
            $this->required_cols = array_map( create_function( '$val', 'return $val - 1;' ), $this->required_cols );
            
            if( ! isset( self::$fields_with_req_cols[$form_id] ) )
                self::$fields_with_req_cols[$form_id] = array();
            
            // keep track of which forms/fields have special require columns so we can still apply GWRequireListColumns 
            // to all list fields and then override with require columns for specific fields as well
            self::$fields_with_req_cols[$form_id] = array_merge( self::$fields_with_req_cols[$form_id], $this->field_ids );
            
        }
        
        $form_filter = $form_id ? "_{$form_id}" : $form_id;
        add_filter("gform_validation{$form_filter}", array(&$this, 'require_list_columns'));

    }

    function require_list_columns($validation_result) {

        $form = $validation_result['form'];
        $new_validation_error = false;

        foreach($form['fields'] as &$field) {

            if(!$this->is_applicable_field($field, $form))
                continue;

            $values = rgpost("input_{$field['id']}");

            // If we got specific fields, loop through those only
            if( count( $this->required_cols ) ) {

                foreach($this->required_cols as $required_col) {
                    if(empty($values[$required_col])) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }

            } else {
                
                // skip fields that have req cols specified by another GWRequireListColumns instance
                $fields_with_req_cols = rgar( self::$fields_with_req_cols, $form['id'] );
                if( is_array( $fields_with_req_cols ) && in_array( $field['id'], $fields_with_req_cols ) )
                    continue;
                
                foreach($values as $value) {
                    if(empty($value)) {
                        $new_validation_error = true;
                        $field['failed_validation'] = true;
                        $field['validation_message'] = $field['errorMessage'] ? $field['errorMessage'] : 'All inputs must be filled out.';
                    }
                }

            }
        }

        $validation_result['form'] = $form;
        $validation_result['is_valid'] = $new_validation_error ? false : $validation_result['is_valid'];

        return $validation_result;
    }

    function is_applicable_field($field, $form) {

        if($field['pageNumber'] != GFFormDisplay::get_source_page($form['id']))
            return false;
    
        if($field['type'] != 'list' || RGFormsModel::is_field_hidden($form, $field, array()))
            return false;
    
        // if the field has already failed validation, we don't need to fail it again
        if(!$field['isRequired'] || $field['failed_validation'])
            return false;
    
        if(empty($this->field_ids))
            return true;
    
        return in_array($field['id'], $this->field_ids);
    }

}

// require specific field columns on a specific form
new GWRequireListColumns( 10, 22 );
new GWRequireListColumns( 13, 22 );
new GWRequireListColumns( 14, 22 );

			
// Redirect users on login based on user role
function mh_login_redirect( $redirect_to, $request, $user ) {
	global $user;	
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} elseif ( in_array( 'board', $user->roles ) ) {
			return get_permalink(3840);
		} elseif ( in_array( 'volunteer', $user->roles ) ) {
			return get_permalink(104);
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}
add_filter('login_redirect', 'mh_login_redirect', 10, 3 );

// logout shortcut and redirect to homepage
function mh_logout_url_shortcode() {
	return wp_logout_url( home_url() );
}
add_shortcode( 'logout-url', 'mh_logout_url_shortcode' );