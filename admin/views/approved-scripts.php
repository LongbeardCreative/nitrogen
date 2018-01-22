<?php

add_action( 'admin_init', 'nt_plugin_init' );

function nt_scripts_init(  ) { 
	register_setting( 'approvedScripts', 'nt_settings' );
}

/**
* MAIN Callback
*
* @since 0.0.3
* @author Evan Hennessy
*/

function approved_scripts_callback() { 
	settings_errors();
?>
		<br>
		<h1>Approved Scripts</h1>

		<?php 
			$feed = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRoFsefs8IL9lZ0sw3ObFC1ZabyZXVfG0CzPV79arrSpLxxcQKZIKn56v7dGaS3AXOFlgGAI4IzPRj5/pub?gid=334785498&single=true&output=csv';

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

			wp_enqueue_script ( 'nt-cdn-script', plugins_url("../inc/cdn.js", __FILE__), array(), false, true );
			add_action( 'admin_enqueue_scripts', 'nt-cdn-script' );

			wp_enqueue_style ( 'nt-script-css', plugins_url("../inc/admin.css", __FILE__) );
			add_action( 'admin_enqueue_scripts', 'nt-script-css' );

			?><h5>All Scripts served by cdn-js</h5><br>
			<?php $enabled_scripts = get_option('nt_scripts_arr'); ?>
			<div class="nt-plugin-wrapper"><?php

			foreach ($newArray as $key => $entry) : ?>
			<?php
				if ( $enabled_scripts[$entry['slug']] ) {
					$status = 'enabled';
				} else {
					$status = 'disabled';
				}
			?>

				<div data-script-version="<?php echo $entry['version'] ?>" data-script-slug="<?php echo $entry['slug'] ?>" data-script-deps="<?php echo $entry['deps'] ?>" class="nt-script-entry <?php echo $status ?>">
					<h3 class="nt-script-title"><?php echo $entry['name'] ?></h3>
					<div>
						<span class="nt-script-approved-version"><strong>Approved Version:</strong> <span id="approved-version"><?php echo $entry['version'] ?></span></span>
						<br>
						<span class="nt-script-curr-version"><strong>Current Version:</strong> <span id="version-result"></span></span>
						<br>
						<span class="nt-script-description"><strong>Description:</strong> <span id="description-result"></span></span>
						<br>
						<!-- <span class="nt-script-assets"><strong>Assets:</strong> <span id="assets-result"></span></span>
						<br> -->
						<a class="script-button button button-secondary nt-<?php echo $status ?>" href="#"><?php echo $status == 'enabled' ? 'Disable' : 'Enable' ?></a>
					</div>
				</div>
			<?php
			endforeach;

		?>
			</div>

	<?php

}