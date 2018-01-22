<?php

require_once( 'pages.php' );
require_once( 'views/development.php' );
require_once( 'views/approved-scripts.php' );
require_once( 'views/approved-plugins.php' );

// wp_enqueue_style ( 'nt-admin-style', plugins_url("inc/admin.css", __FILE__) );
// add_action( 'admin_enqueue_scripts', 'nt-admin-style' );

add_action( 'wp_ajax_nt_scripts', 'nt_update_scripts' );
	
function nt_update_scripts() {
    $option = 'nt_scripts_arr';
    $script = $_POST['scriptURL'];
    $slug = $_POST['slug'];
    $version = $_POST['version'];

    $script = array( $slug => array(
    				 	'scripts' => $script,
    				 	'version' => $version ));

    if( !isset( $option ) || $option == '' || !isset( $script ) ) {
        wp_die(
            json_encode(
                array(
                    'success' => false,
                    'message' => 'An Error Occured (Bad POST data).'
                )
            )
        );
    }
    
    //Get current DB option
    $currVal = get_option($option);

    if ( !empty( $currVal ) ) {
    	if ( $currVal[$slug] ) {
    		unset( $currVal[$slug] );
    		$script = $currVal;
    	} else {
    		//Push script to array
   			$script = array_merge($currVal, $script);
   		}
    }

   	//update option in DB
   	update_option( $option, $script );

    wp_die(
        json_encode(
            array(
                'success' => true,
                'message' => $slug
            )
        )
    );
}