<?php
/*
Plugin Name:  Profectus
Plugin URI:   https://www.longbeard.com/profectus-report
Description:  Automates various LB specific tasks. Do not delete.
Version:      0.0.1(0001)
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
require_once( plugin_dir_path(__FILE__) . 'overrides/override.php');
require_once( plugin_dir_path(__FILE__) . 'admin/profectus_admin.php');


function pf_enqueue_styles() {
    wp_register_style( 'main_css',  plugin_dir_url( __FILE__ ) . 'assets/style.css' );
    wp_enqueue_style( 'main_css' );
}
add_action( 'oxygen_enqueue_scripts', 'pf_enqueue_styles' );