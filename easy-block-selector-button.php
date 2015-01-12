<?php
/*
 * Plugin Name: Easy Block Selector
 * Plugin URI: http://wordpress.org/extend/plugins/easy-block-selector/
 * Description: Extend the range selection of TinyMCE.
 * Version: 0.1.1
 * Author: sekishi
 * Author URI: http://lab.planetleaf.com/
 * Text Domain: easy-block-selector
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function wp_ebs_plugin_url( $path = '' ) {
	$url = untrailingslashit( WP_EASYBLOCKSELECTOR_PLUGIN_URL );

	if ( ! empty( $path ) && is_string( $path ) && false === strpos( $path, '..' ) )
		$url .= '/' . ltrim( $path, '/' );

	return $url;
}


class EasyBlockSelector {
	var $version = '0.1.0';
	var $buttons = array();
	
	
	function EasyBlockSelector() {
		
		if ( ! defined( 'WP_EASYBLOCKSELECTOR_PLUGIN_URL' ) )
			define( 'WP_EASYBLOCKSELECTOR_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
		
		$this->ebs_addbuttons();
		
	}
	
	function ebs_addbuttons() {
		global $wp_version, $wpmu_version, $shortcode_tags, $wp_scripts;
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
			return;
		}
		
		if ( get_user_option('rich_editing') == 'true') {
			add_filter( 'mce_external_plugins', array(&$this, 'mce_external_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'mce_buttons') );
		}
	}
	
	
	// Load the custom TinyMCE plugin
	function mce_external_plugins( $plugins ) {
		$plugins['EasyBlockSelector'] = wp_ebs_plugin_url('tinymce3/editor_plugin.js');
		return $plugins;
	}
	// Add the custom TinyMCE buttons
	function mce_buttons( $buttons ) {
		array_push( $buttons, 'easy-block-selector-button' );
		return $buttons;
	}


}

// Start this plugin once all other plugins are fully loaded
add_action('init', 'EasyBlockSelector' );


function EasyBlockSelector() {
	
	global $EasyBlockSelector;
	$EasyBlockSelector = new EasyBlockSelector();
}

?>
