<?php
/**
 * Add Dashboard pages/subpages for different settings
 *
 */

/**
 * Main Page
 * 
 * @since 0.0.2
 * @author Evan Hennessy
 */

add_action( 'admin_menu', 'nt_add_admin_menu', 11 );

function nt_add_admin_menu(  ) { 
	add_menu_page( 	'Development Settings', //Page Title
					'Nitrogen', //Menu Title
					'manage_options', //Req. Capabilities
					'nitrogen', //slug
					'nt_main_callback', //callback
					'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNTAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwIDUwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHRpdGxlPmJvbGQ8L3RpdGxlPjxnPjxnPjxwYXRoIGQ9Ik0xNi45LDQ5LjljLTAuMiwwLTAuNS0wLjEtMC43LTAuMmMtMC42LTAuMy0wLjktMC45LTAuOC0xLjZsMy43LTIxLjZoLTguNWMtMC42LDAtMS4xLTAuNC0xLjQtMC45QzksMjUsOS4yLDI0LjMsOS42LDIzLjlMMzEuOSwwLjZDMzIuMywwLjEsMzMsMCwzMy42LDAuM2MwLjYsMC4zLDAuOSwwLjksMC44LDEuNmwtMy43LDIxLjVoOC42YzAuNiwwLDEuMSwwLjQsMS40LDAuOWMwLjIsMC42LDAuMSwxLjItMC4zLDEuNkwxOCw0OS40QzE3LjcsNDkuNywxNy4zLDQ5LjksMTYuOSw0OS45eiBNMjIuMiwyNi40bC0zLDE3LjNsMTYuNi0xNy4zaC02LjljLTAuNCwwLTAuOS0wLjItMS4xLTAuNWMtMC4zLTAuMy0wLjQtMC44LTAuMy0xLjJsMy4yLTE4LjVMMTQuMiwyMy40aDkuM2MwLjgsMCwxLjUsMC43LDEuNSwxLjVzLTAuNywxLjUtMS41LDEuNUgyMi4yeiIvPjwvZz48L2c+PC9zdmc+'
				);

}

/**
 * Development Page
 * 
 * @since 0.0.2
 * @author Evan Hennessy
*/

add_action( 'admin_menu', 'nt_add_dev_page', 12 );

function nt_add_dev_page(  ) { 
	add_submenu_page( 	'nitrogen', //Parent Slug
						'Development Settings', //Page Title
						'Settings', //Menu Title
						'manage_options', //Req. Capabilities
						'nitrogen-settings', //slug
						'nt_options_page_callback' //callback
					);
}

/**
 * Scripts Page
 * 
 * @since 0.0.3
 * @author Evan Hennessy
*/

add_action( 'admin_menu', 'nt_add_scripts_page', 12 );

function nt_add_scripts_page(  ) { 
	add_submenu_page( 	'nitrogen', //Parent Slug
						'Approved Scripts', //Page Title
						'Approved Scripts', //Menu Title
						'manage_options', //Req. Capabilities
						'nt_scripts', //slug
						'approved_scripts_callback' //callback
					);
}

/**
 * Plugin Page
 * 
 * @since 0.0.2
 * @author Evan Hennessy
 */

add_action( 'admin_menu', 'nt_add_plugin_page', 12 );

function nt_add_plugin_page(  ) { 
	add_submenu_page( 	'nitrogen',
						'Approved Plugins', //Page Title
						'Approved Plugins', //Menu Title
						'manage_options', //Req. Capabilities
						'nt_plugins', //slug
						'approved_plugins_callback' //callback
					);
	remove_submenu_page( 'nitrogen', 'nitrogen' );
}

