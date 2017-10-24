<?php
add_action( 'admin_menu', 'pf_add_admin_menu' );
add_action( 'admin_init', 'pf_settings_init' );


function pf_add_admin_menu(  ) { 

	add_submenu_page( 'ct_dashboard_page', 'Profectus Settings', 'Profectus Settings', 'manage_options', 'profectus', 'pf_options_page' );

}


function pf_settings_init(  ) { 

	register_setting( 'pluginPage', 'pf_settings' );

	add_settings_section(
		'pf_pluginPage_section', 
		__( 'API Engine', 'profectus' ), 
		'pf_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'pf_select_field_0', 
		__( 'Source', 'profectus' ), 
		'pf_select_field_0_render', 
		'pluginPage', 
		'pf_pluginPage_section' 
	);


}


function pf_select_field_0_render(  ) { 

	$options = get_option( 'pf_settings' );
	?>
	<select name='pf_settings[pf_api_source]'>
		<option value='1' <?php selected( $options['pf_api_source'], 1 ); ?>>Oxygen</option>
		<option value='2' <?php selected( $options['pf_api_source'], 2 ); ?>>Longbeard</option>
	</select>

<?php

}


function pf_settings_section_callback(  ) { 

	echo __( 'Tweak and Engage Profectus Engine', 'profectus' );

}


function pf_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>Profectus Settings</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}