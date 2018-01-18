<?php

require_once( 'pages.php' );
require_once( 'views/development.php' );
require_once( 'views/approved-scripts.php' );
require_once( 'views/approved-plugins.php' );

wp_enqueue_style ( 'nt-admin-style', plugins_url("inc/admin.css", __FILE__) );
add_action( 'admin_enqueue_scripts', 'nt-admin-style' );