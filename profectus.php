<?php
/*
Plugin Name:  Profectus
Plugin URI:   https://www.longbeard.com/profectus-report
Description:  Automates various LB specific tasks. Do not delete.
Version:      0.0.2(0024)
Author:       Evan Hennessy
Author URI:   https://www.hennessyevan.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

//Exit if Accessed Directly
if (! defined('ABSPATH')) {
    exit;
}

//Plugin Requirements
// require_once( plugin_dir_path(__FILE__) . 'overrides/override.php');
require_once( plugin_dir_path(__FILE__) . 'admin/profectus_admin.php');

if(file_exists('assets/functions.php')) {
    include 'assets/functions.php';
}

//Front and Builder Styles
function pf_enqueue_styles() {
    wp_enqueue_style( 'main_css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), null );
}
add_action( 'oxygen_enqueue_scripts', 'pf_enqueue_styles' );


//Front Scripts
function pf_enqueue_scripts() {
	$dir = plugin_dir_url( __FILE__ ) . 'assets/js';
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
	            if (pathinfo($file, PATHINFO_EXTENSION) == 'js') {
	            	wp_enqueue_script( $file, plugin_dir_url(__FILE__) . $file, array( 'jquery' ), false, true );
	            }
	        }
	        closedir($dh);
	    }
	}
}

//Builder Scripts
function pf_cron_script() {
	wp_enqueue_script( 'pf_cron', plugin_dir_url(__FILE__) . 'admin/inc/pf_cron.js', array( 'jquery' ), false, true );
}
add_action( 'oxygen_enqueue_builder_scripts', 'pf_cron_script' );