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

function profectus_init() {
    add_sub_menu_page(
        'toplevel_page_ct_dashboard_page',
        'Profectus Settings',
        'Profectus',
        'manage_options',
        'profectus',
        'profectus_settings_callback'
    );
}
add_action( 'admin_menu', 'profectus_init' );
