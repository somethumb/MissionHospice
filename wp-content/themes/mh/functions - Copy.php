<?php
/**
 * functions and definitions.
 */

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
	global $wp_styles;
	
	// Load Reset css
	wp_enqueue_style( 'reset-style', get_stylesheet_directory_uri() . '/cssreset-min.css'	);

	
		// Load Google Fonts
		wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Serif:400,700|Noto+Sans:400,700'	);
		
		// Loads superfish scrips and styles for dropdown menus
		wp_enqueue_style( 
			'superfish-style', 
			get_stylesheet_directory_uri() . '/css/superfish.css'
		);		
		wp_enqueue_script(
			'superfish-script',
			get_stylesheet_directory_uri() . '/js/superfish.js',
			array('jquery')
		);
	
		// Load Google Libraries jQuery
		wp_deregister_script( 'jquery' );
		wp_register_script(
			'jquery',
			'//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
			false
		);
		wp_enqueue_script('jquery');
		
		// Load Google Libraries jQuery UI
		wp_deregister_script( 'jquery-ui-core' );
		wp_register_script(
			'jquery-ui-core',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
			false
		);
		wp_enqueue_script('jquery-ui-core');
		
		// Load jCycle 2
		wp_enqueue_script(
			'jcycle2-script',
			'//malsup.github.io/jquery.cycle2.js',
			array('jquery')
		);
		
		// Load youtube popup
		wp_enqueue_style( 
			'youtube-style', 
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css'
		);
		wp_enqueue_script(
			'youtube-script',
			get_stylesheet_directory_uri() . '/js/jquery.youtubepopup.min.js',
			array('jquery')
		);
		
		// Loads main stylesheet.
		wp_enqueue_style( 
			'mh-style', 
			get_stylesheet_uri()
		);
	
		// Load General scripts
		wp_enqueue_script(
			'general-script',
			get_stylesheet_directory_uri() . '/js/scripts.js',
			array('jquery')
		);
		
}
add_action( 'wp_enqueue_scripts', 'mh_scripts_styles' );

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
		<div class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout=6000>
			<?php foreach ($randomslide as $field):
			
				// vars
				$image = $slides[$field]['image'];
				$testimonial = $slides[$field]['testimonial'];
				$author = $slides[$field]['author'];
		 
				?>
				<div class="sld_ctnr">
					<?php if($image) { ?>
					<div class="sld_ctnt"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
					<img src="<?php echo $image['sizes']['Slideshow']; ?>" alt="<?php echo $testimonial; ?>">
					<?php } else { ?>
					<div class="sld_ctnt full"><div class="mid"><p><?php echo $testimonial; ?></p><cite><?php echo $author; ?></cite></div></div>
					<?php } ?>
				</div>
			<?php endforeach; ?>
		</div>
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

// Validate quantity field
add_filter("gform_field_validation_1_31", "mh_quantity_validation", 10, 4);
function mh_quantity_validation($result, $value, $form, $field){
	if(intval($value) != $value) {
		$result["message"] = __("Please enter a whole dollar amount.", "gravityforms");
	}
	return $result;
}

// Force donate page to be ssl
function mh_secure_page_force_ssl( $force_ssl, $post_id = 0 ) {
    $force_ssl_on_these_posts = array(1332,104);

    if(in_array($post_id, $force_ssl_on_these_posts )) {
        return true;
    } else {
		return false;
	}

    return $force_ssl;
}
add_filter('force_ssl' , 'mh_secure_page_force_ssl', 1, 3);

// Number of Guests and Meal Options on Aux Gala form
//add_filter("gform_pre_render_5", "mh_guest_meal_options_5");
function mh_guest_meal_options_5($form){
	if (!IS_ADMIN) {
		$current_page = GFFormDisplay::get_current_page($form["id"]);
	}
	// Start page 2
	if ($current_page == 2) {
		list($numtix, $pricetix) = explode("|", rgpost('input_3'));

		//Get quantity (defaults to 1)
		$quantitytix = rgpost('input_4');
		$giftamount = rgpost('input_10');
		if ($quantitytix > 1) {
			$numtix = $numtix * $quantitytix;
		}
		
		foreach($form["fields"] as &$field) :
			if ($field["id"] == 19) {
				for ($q=1; $q<=$numtix; $q++) {
					$html_content .= '<li class="gfield gf_left_half" id="field_5_19.'.$q.'">';
						$html_content .= '<label for="field_5_19.'.$q.'" class="gfield_label">' . $field["label"] . '</label>';
						$html_content .= '<div class="ginput_container"><input type="text" tabindex="11" class="medium" value="" id="input_5_19.'.$q.'" name="input_19.'.$q.'"></div>';
					$html_content .= '</li>';
				}
				echo $html_content;
			}
		endforeach;
		
		echo 'q'.$quantitytix . ',';
		echo 'n'.$numtix . ',';
		echo 'p'.$pricetix . ',';
		echo 'g'.$giftamount . ',';
	}	
	return $form;
}


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
        
        add_filter( 'gform_pre_render_' . $form_id, array( $this, 'pre_render' ) );
        
    }
    
    function pre_render( $form ) {
        ?>
        
        <style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $this->_args['list_field_id']; ?> .gfield_list_icons { display: none; } </style>
        
        <?php
        
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

// Product Choice 1
new GWAutoListFieldRows( array( 
	'form_id' => 5,
	'list_field_id' => 22,
	'input_html_id' => '#input_5_4'
) );


//add_filter("gform_pre_render_5", "mh_guest_meal_options_5_22");
function mh_guest_meal_options_5_22($form){
	if (!IS_ADMIN) {
		$current_page = GFFormDisplay::get_current_page($form["id"]);
	}
	// Start page 2
	if ($current_page == 2) {
		
		switch (rgpost('input_3')) {
			case "1|135":
				// Product Choice 1
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#input_5_4'
				);
			case "10|1350":
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#choice_3_1'
				);
			case "4|2500":
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#choice_3_2'
				);
			case "10|5000":
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#choice_3_3'
				);
			case "20|10000":
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#choice_3_4'
				);
			case "20|20000":
				$args = array( 
					'form_id' => 5,
					'list_field_id' => 22,
					'input_html_id' => '#choice_3_5'
				);
		}
        ?>
        
        <style type="text/css"> #field_<?php echo $form['id']; ?>_<?php echo $args['list_field_id']; ?> .gfield_list_icons { display: none; } </style>
        
        <?php
        
        add_filter( 'gform_register_init_scripts', 'register_init_script' );
        
        if( ! self::$_is_script_output )
            $this->output_script();
		
	}	
	return $form;
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
new GWRequireListColumns( 5, 22, array( 11, 12 ) );

//This filter declaration targets the third column of the field whose id is 9 in form whose id is 21
add_filter("gform_column_input_5_22_2", "change_column2_content", 10, 5);
function change_column2_content($input_info, $field, $text, $value, $form_id){
	//build field name, must match List field syntax to be processed correctly
	$input_field_name = 'input_' . $field["id"] . '[]';
	$tabindex = GFCommon::get_tabindex();
	return array("type" => "select", "choices" => "First Choice,Second Choice");
}