<?php
/*
Plugin Name:  Nitrogen
Plugin URI:   https://www.longbeard.com/nitrogen-report
Description:  Automates various LB specific tasks. Do not delete.
Version:      0.1.1(0038)
Author:       Evan Hennessy
Author URI:   https://www.hennessyevan.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

//Exit if Accessed Directly
if (! defined('ABSPATH')) {
    exit;
}

define("NT_VERSION", "0.1.1");
define("NT_OXYGEN_REQUIRED_VERSION", "1.4");



/**
* Override Files
* 
* @since 0.0.1
* @author Evan Hennessy
**/

function nt_activate() {
	$plugin_root = WP_CONTENT_DIR . '/plugins';
	$oxygen_original = $plugin_root . '/oxygen/component-framework/';
	$nitrogen_overrides_dir = $plugin_root . '/nitrogen/overrides/';

	$file = file_get_contents($oxygen_original . "components/component.class.php");
	$file = str_replace("\$advanced_defaults = array", "\$advanced_blank = array", $file);

	$initfile = file_get_contents($oxygen_original . "component-init.php");
	$initfile = str_replace("\$css .= \"@media (max-width: 992px)", "\$cssbak = \"@media (max-width: 992px)", $initfile);

	file_put_contents($oxygen_original . "components/component.class.php", $file);
	file_put_contents($oxygen_original . "component-init.php", $initfile);

	if (!get_option('initial_set')) {
		update_option('uploads_use_yearmonth_folders', FALSE);
		update_option('permalink_structure', '/%postname%/');
		update_option('initial_set', TRUE);
	}
}
register_activation_hook( __FILE__, 'nt_activate' );



/**
* Plugin Requirements 
* 
* @since 0.0.1
* @author Evan Hennessy
**/

require_once( plugin_dir_path(__FILE__) . 'admin/nt_admin.php');
// require_once( plugin_dir_path(__FILE__) . 'overrides/override.php');

if ( file_exists( plugin_dir_path(__FILE__) . 'assets/functions.php' ) ) {
	require_once( plugin_dir_path(__FILE__) . 'assets/functions.php' );
}



/**
* DEFAULT SCRIPTS
*
* @since 0.0.1
* @author Evan Hennessy
**/

//Front and Builder Styles
function nt_enqueue_styles() {
    wp_enqueue_style( 'main_css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), null );
}
add_action( 'oxygen_enqueue_builder_scripts', 'nt_enqueue_styles', 1 );
add_action( 'wp_enqueue_scripts', 'nt_enqueue_styles', 199 );

//Approved Scripts Enqueue
function nt_approved_scripts() {
	$scripts = get_option('nt_scripts_arr');

	foreach ( $scripts as $slug => $vars ) {
		$version = $vars['version'];
		foreach ( $vars['scripts'] as $url ) {
			if ( get_extension($url) == 'css' ) {
	    		wp_enqueue_style( $slug, 'https://cdnjs.cloudflare.com/ajax/libs/' . $slug . '/' . $version . '/' . $url, array(), false );
	    	} elseif ( get_extension($url) == 'js' ) {
	    		wp_enqueue_script( $slug, 'https://cdnjs.cloudflare.com/ajax/libs/' . $slug . '/' . $version . '/' . $url, array(), false, true );
	    	}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'nt_approved_scripts' );


/**
* Development Scripts
* 
* @since 0.0.3
* @author Evan Hennessy
**/

function nt_cron_script() {
	wp_enqueue_script( 'nt_cron', plugin_dir_url(__FILE__) . 'admin/inc/nt_cron.js', array( 'jquery' ), false, true );
}
if (get_option( 'nt_settings' )['nt_devmode'] == 1) {
	add_action( 'oxygen_enqueue_scripts', 'nt_cron_script' );
}

function add_meta_tags() {
	?><meta name="cronrate" content="<?php echo get_option( 'nt_settings' )['nt_cronrate'] ?>"/><?php
}
add_action('wp_head', 'add_meta_tags');