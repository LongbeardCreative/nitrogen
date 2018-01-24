<?php

if ( ! function_exists( 'plugins_api' ) )
	// require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

add_action( 'admin_init', 'nt_plugin_init' );

	function nt_plugin_init(  ) { 
		register_setting( 'approvedPage', 'nt_settings' );

		//REQUEST SECTION
		add_settings_section( 'nt_request_section', __( 'Request Plugin Approval', 'nitrogen' ), 'nt_request_section_callback', 'approvedPage' );

			add_settings_field( 'nt_request_field', __( 'Plugin URL', 'nitrogen' ), 'nt_request_field_render', 'approvedPage', 'nt_request_section' );

	}

	function nt_request_section_callback(  ) {}

	function nt_request_field_render(  ) { 

		$options = get_option( 'nt_settings' );
		?>
			<input id="nt_request_field" name="nt_settings[nt_request]" type="text">
		<?php

	}

/**
* MAIN Callback
*
* @since 0.0.3
* @author Evan Hennessy
*/

function approved_plugins_callback() { 
	settings_errors();
?>
		<br>
		<h1>Approved Plugins</h1>
		<br>

		<?php
			settings_fields( 'approvedPage' );
			do_settings_sections( 'approvedPage' );
			submit_button('Send');
		?>
		<br>

		<?php 
			$feed = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRoFsefs8IL9lZ0sw3ObFC1ZabyZXVfG0CzPV79arrSpLxxcQKZIKn56v7dGaS3AXOFlgGAI4IzPRj5/pub?gid=0&single=true&output=csv';

			$keys = array();
			$newArray = array();
			// Function to convert CSV into associative array
			function csvToArray($file, $delimiter) {
			  if (($handle = fopen($file, 'r')) !== FALSE) {
			    $i = 0;
			    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
			      for ($j = 0; $j < count($lineArray); $j++) {
			        $arr[$i][$j] = $lineArray[$j];
			      }
			      $i++;
			    }
			    fclose($handle);
			  }

			  return $arr;
			}
			// Do it
			$data = csvToArray($feed, ',');
			// Set number of elements (minus 1 because we shift off the first row)
			$count = count($data) - 1;

			//Use first row for names
			$labels = array_shift($data);
			foreach ($labels as $label) {
			  $keys[] = $label;
			}
			// Add Ids, just in case we want them later
			$keys[] = 'id';
			for ($i = 0; $i < $count; $i++) {
			  $data[$i][] = $i;
			}

			// Bring it all together
			for ($x = 0; $x < $count; $x++) {
			  $d = array_combine($keys, $data[$x]);
			  $newArray[$x] = $d;
			}

			wp_enqueue_style( 'plugins-css', plugin_dir_url( __FILE__ ) . 'css/plugin.css' );

			?><h2>Approved Plugin Library</h2><br>
			<div class="plugin-wrapper"><?php

			/** Prepare our query */
		    $plugin = plugins_api( 'plugin_information', 
		    	array(
		    		'slug' => 'jetpack'
		    	)
		    );
		 
		    /** Check for Errors & Display the results */
		    if ( is_wp_error( $plugin ) ) {
		 
		        echo '<pre>' . print_r( $plugin->get_error_message(), true ) . '</pre>';
		 
		    } else { ?>
		 
		            <p>Name: <?php echo $plugin->name ?></p>
		            <p>Homepage: <?php echo $plugin->homepage ?></p>
		            <p>Last Updated: <?php echo $plugin->last_updated ?></p>
		            <p>URL: <?php echo $plugin->download_link ?></p>
		 <?php } ?>

			</div>

	<?php

}