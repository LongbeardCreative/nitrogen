<?php

add_action( 'admin_init', 'nt_settings_init' );

function nt_settings_init(  ) { 
	register_setting( 'pluginPage', 'nt_settings' );

	//DEVMODE SETTINGS SECTION
	add_settings_section( 'nt_devmode_section', __( 'Development Mode', 'nitrogen' ), 'nt_devmode_section_callback', 'pluginPage' );

		add_settings_field( 'nt_devmode_field', __( 'Development Mode', 'nitrogen' ), 'nt_devmode_field_render', 'pluginPage', 'nt_devmode_section' );
		add_settings_field( 'nt_cronrate_field', __( 'CSS Refresh Rate (seconds)', 'nitrogen' ), 'nt_cronrate_field_render', 'pluginPage', 'nt_devmode_section' );

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

/**
* CALLBACKS
*
* @since 0.0.2
* @author Evan Hennessy
*/


function nt_script_section_callback(  ) { 

	echo __( 'Approved External Scripts', 'nitrogen' );

}

function nt_devmode_section_callback(  ) { 

	echo __( 'Enable Development Mode', 'nitrogen' );

}

/**
* MAIN Callback
*
* @since 0.0.2
* @author Evan Hennessy
*/

function nt_options_page_callback(  ) { 
settings_errors();
	?>
	<script src="../inc/admin.js"></script>
	<form class="dev-options" action='options.php' method='post'>

		<h2>Development</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}