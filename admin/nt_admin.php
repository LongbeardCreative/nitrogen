<?php
add_action( 'admin_menu', 'nt_add_admin_menu' );
add_action( 'admin_init', 'nt_settings_init' );

function nt_add_admin_menu(  ) { 

	add_submenu_page( 'ct_dashboard_page', 'Nitrogen Settings', 'Nitrogen Settings', 'manage_options', 'nt-development', 'nt_options_page' );

}

//ADMIN JS
// function nt_admin_js() {
// 	wp_enqueue_script( 'nt_admin_js', plugin_dir_url( __FILE__ ) . 'inc/nt_admin.js', array( 'jquery' ), false, false );
// }
// add_action( 'admin_enqueue_scripts', 'nt_admin_js' );


function nt_settings_init(  ) { 
	register_setting( 'pluginPage', 'nt_settings' );

	//API SETTINGS SECTION
	// add_settings_section( 'nt_API_section', __( 'API Engine', 'nt-development' ), 'nt_api_section_callback', 'pluginPage' );

	// 	add_settings_field( 'nt_api_field', __( 'Source', 'nt-development' ), 'nt_api_field_render', 'pluginPage', 'nt_API_section' );

	//SCRIPTS SETTINGS SECTION
	add_settings_section( 'nt_script_section', __( 'Custom Scripts for Oxygen', 'nt-development' ), 'nt_script_section_callback', 'pluginPage' );

		add_settings_field( 'nt_script_field', __( 'Script', 'nt-development' ), 'nt_script_field_render', 'pluginPage', 'nt_script_section' );

	//DEVMODE SETTINGS SECTION
	add_settings_section( 'nt_devmode_section', __( 'Development Mode', 'nt-development' ), 'nt_devmode_section_callback', 'pluginPage' );

		add_settings_field( 'nt_devmode_field', __( 'Development Mode', 'nt-development' ), 'nt_devmode_field_render', 'pluginPage', 'nt_devmode_section' );
		add_settings_field( 'nt_cronrate_field', __( 'CSS Refresh Rate (seconds)', 'nt-development' ), 'nt_cronrate_field_render', 'pluginPage', 'nt_devmode_section' );

}

//****************************************************************************

function nt_api_field_render(  ) { 

	$options = get_option( 'nt_settings' );
	?>
	<select name='nt_settings[nt_api_source]'>
		<option value='1' <?php selected( $options['nt_api_source'], 1 ); ?>>Oxygen</option>
		<option value='2' <?php selected( $options['nt_api_source'], 2 ); ?>>Longbeard</option>
	</select>

<?php

}

function nt_script_field_render(  ) { 

	$options = get_option( 'nt_settings' );
	$scripts = $options['nt_script_url'];
	foreach ($scripts as $script) { ?>
		<span><?php echo $script ?></span><br>
	<?php }
	echo "<input id='nt_script_field' name='nt_settings[nt_script_url]' size='40' type='text' value='" . $scripts . "' placeholder='Script URL' />";

}

function nt_devmode_field_render(  ) { 

$options = get_option( 'nt_settings' );
	?>
	<select name='nt_settings[nt_devmode]'>
		<option value='1' <?php selected( $options['nt_devmode'], 1 ); ?>>ON</option>
		<option value='2' <?php selected( $options['nt_devmode'], 2 ); ?>>OFF</option>
	</select>

<?php	

}

function nt_cronrate_field_render(  ) { 

	$options = get_option( 'nt_settings' );
	?>
		<input id="nt_cronrate_field" name="nt_settings[nt_cronrate]" type="number" min="1" max="20" value="<?php echo $options['nt_cronrate'] ?>">
	<?php

}

//CALLBACKS
function nt_api_section_callback(  ) { 

	echo __( 'Tweak and Engage Nitrogen Engine', 'nitrogen' );

}

function nt_script_section_callback(  ) { 

	echo __( 'Add External Scripts to Oxygen', 'nitrogen' );

}

function nt_devmode_section_callback(  ) { 

	echo __( 'Enable Development Mode', 'nitrogen' );

}

//Display the options page
function nt_options_page(  ) { 
settings_errors();
	?>
	<form action='options.php' method='post'>

		<h2>Development Settings</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}