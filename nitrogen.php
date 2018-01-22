<?php
/*
Plugin Name:  Nitrogen
Plugin URI:   https://www.longbeard.com/nitrogen-report
Description:  Automates various LB specific tasks. Do not delete.
Version:      0.0.3(0041)
Author:       Evan Hennessy
Author URI:   https://www.hennessyevan.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

//Exit if Accessed Directly
if (! defined('ABSPATH')) {
    exit;
}

define("NT_VERSION", "0.0.2");
define("NT_OXYGEN_REQUIRED_VERSION", "1.4");


function versions_is_ok() {

		if ( ! defined("CT_VERSION") ) {
			add_action( 'admin_notices', array( $this, 'oxygen_not_found' ) );
			return false;
		}

		if ( version_compare( CT_VERSION, NT_OXYGEN_REQUIRED_VERSION ) >= 0) {
	    	return true;
		}
		else {
			add_action( 'admin_notices', array( $this, 'oxygen_wrong_version' ) );
			return false;
		}
	}

	function oxygen_not_found() {
		
		$classes = 'notice notice-error';
		$message = __( 'Can\'t start Selector Detector add-on. Oxygen main plugin not found active in your install.', 'oxygen' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', $classes, $message ); 
	}

	function oxygen_wrong_version() {
		
		$classes = 'notice notice-error';
		$message = __( 'Your Oxygen version is not supported by Selector Detector add-on. Minimal required Oxygen version is:', 'oxygen' );

		printf( '<div class="%1$s"><p>%2$s <b>%3$s</b></p></div>', $classes, $message, NT_OXYGEN_REQUIRED_VERSION ); 
	}



//Plugin Requirements
require_once( plugin_dir_path(__FILE__) . 'admin/nt_admin.php');

if ( file_exists( plugin_dir_path(__FILE__) . 'assets/functions.php' ) ) {
	require_once( plugin_dir_path(__FILE__) . 'assets/functions.php' );
}

function get_extension($file) {
	$extension = end(explode(".", $file));
	return $extension ? $extension : false;
}



/* DEFAULT SCRIPTS */
//Front and Builder Styles
function nt_enqueue_styles() {
    wp_enqueue_style( 'main_css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), null );
}
add_action( 'oxygen_enqueue_builder_scripts', 'nt_enqueue_styles', 1 );
add_action( 'oxygen_enqueue_scripts', 'nt_enqueue_styles', 20 );

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


//Development Scripts
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