<?php
/*
Plugin Name:  Nitrogen
Plugin URI:   https://www.longbeard.com/nitrogen-report
Description:  Automates various LB specific tasks. Do not delete.
Version:      0.0.2(0033)
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
require_once( plugin_dir_path(__FILE__) . 'admin/nt_admin.php');

if ( file_exists( plugin_dir_path(__FILE__) . 'assets/functions.php' ) ) {
	require_once( plugin_dir_path(__FILE__) . 'assets/functions.php' );
}

//Oxygen CSS Overrides
// function nt_override_styles() {
//     wp_enqueue_style( 'override_css', plugin_dir_url( __FILE__ ) . 'overrides/override.css', array(), null );
// }
// add_action( 'wp_enqueue_scripts', 'nt_override_styles', 9999 );


/* DEFAULT SCRIPTS */
//Front and Builder Styles
function nt_enqueue_styles() {
    wp_enqueue_style( 'main_css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), null );
}
add_action( 'oxygen_enqueue_scripts', 'nt_enqueue_styles' );

//Development Scripts
function nt_cron_script() {
	wp_enqueue_script( 'nt_cron', plugin_dir_url(__FILE__) . 'admin/inc/nt_cron.js', array( 'jquery' ), false, true );
}
if (get_option( 'nt_settings' )['nt_devmode'] == 1) {
	add_action( 'oxygen_enqueue_scripts', 'nt_cron_script' );
	add_meta_tags();
}

function add_meta_tags() {
	?><meta name="cronrate" content="<?php echo get_option( 'nt_settings' )['nt_cronrate'] ?>"/><?php
}
add_action('wp_head', 'add_meta_tags');

/* CUSTOM SCRIPTS */
//Externals
function nt_external_scripts() {
	$scripts = explode(',', get_option( 'nt_settings' )['nt_script_url']);

	foreach ($scripts as $script) {
		wp_enqueue_script( 'nt_' . $script, $script );
	}
}
add_action( 'oxygen_enqueue_scripts', 'nt_external_scripts' );