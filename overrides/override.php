<?php
global $nitrogen_engine;
$nitrogen_on = TRUE;

//GET plugin directory
$plugin_root = WP_CONTENT_DIR . '/plugins';
$oxygen_api_dir = $plugin_root . '/oxygen/component-framework/includes/';
$nitrogen_overrides_dir = $plugin_root . '/nitrogen/overrides/';
$api_source = get_option( 'nt_settings' )['nt_api_source'];
$nt_using = get_option( 'nt_using' );

//Rename Old Oxygen API
// if ( file_exists( $oxygen_api_dir . 'api.php' ) && $nitrogen_on == FALSE ) {
// 	rename( $oxygen_api_dir . 'api.php', $oxygen_api_dir . 'api-oxygen.php' );
// }

if ( $api_source == 1 &&  $nt_using !== 1 ) {
	copy( $nitrogen_overrides_dir . 'lb_api.php', $oxygen_api_dir . 'api.php' );
} else if ( $api_source == 2 &&  $nt_using !== 2 ) {
	copy( $nitrogen_overrides_dir . 'oxy_api.php', $oxygen_api_dir . 'api.php' );
}

function nt_using( $source ) {
	if ( ! get_option( 'nt_using' ) ) {
		add_option( 'nt_using', $source, '', 'no' );
	} else {
		update_option( 'nt_using', $source, 'no' );
	}
}