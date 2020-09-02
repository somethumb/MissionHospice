<?php
/*
Plugin Name: Disable Plugin for URl
Plugin URI: https://www.glowlogix.com
Description: Disable plugins for for specific backend pages.
Author: Muhammad Usama M.
Version: 1.0.0
*/
add_filter( 'option_active_plugins', 'disable_plugins_per_page' );
function disable_plugins_per_page( $plugin_list ) {

    // Quit immediately if not post edit area.
	if (is_admin()) {
    global $pagenow;
	  if (( $_GET['gf_page'] == 'select_columns' )) {
        $disable_plugins = array (
            // Plugin Name
            'nextgen-gallery/nggallery.php'
        );
        $plugins_to_disable = array();
        foreach ( $plugin_list as $plugin ) {
            if ( true == in_array( $plugin, $disable_plugins ) ) {
                //error_log( "Found $plugin in list of active plugins." );
                $plugins_to_disable[] = $plugin;
            }
        }
        // If there are plugins to disable then remove them from the list,
        // otherwise return the original list.
        if ( count( $plugins_to_disable ) ) {
            $new_list = array_diff( $plugin_list, $plugins_to_disable );
            return $new_list;
        }   
    }
	}
    return $plugin_list;
}