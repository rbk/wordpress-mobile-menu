<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*

Plugin name: Mobile Menu
Author: Richard Keller
URI:
Version: 1
Description:

*/
require_once('rbk-mobile-menu-output.php');
require_once('rbk-menu-settings-page.php');

# Add plugin option in Plugins page
function rbk_plugin_settings_link( $links, $file ) {
	if ( $file == plugin_basename( basename(dirname(__FILE__)).'/index.php' ) ) {
		$links[] = '<a href="options-general.php?page=rbk_mobile_menu">'.__('Settings').'</a>';
	}

	return $links;
}
if( is_admin() ){
	add_filter( 'plugin_action_links', 'rbk_plugin_settings_link', 10, 2 );
}

function rbk_append_style( ){
	wp_enqueue_style('rbk-menu-style', plugins_url('css/main.css',__FILE__) );
	wp_enqueue_style('rbk-icon-font-style', plugins_url('rbk_menu_icons/rbk-font-style.css',__FILE__) );
}
add_action( 'wp_head', 'rbk_append_style' );


function rbk_enqueue_menu_js( ) {
	wp_enqueue_script( 'rbk-menu-javascript', plugins_url('js/menu.js',__FILE__), array('jquery'), 1.0, true );
}
add_action( 'wp_enqueue_scripts', 'rbk_enqueue_menu_js' );


?>