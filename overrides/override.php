<?php

function removeDefaultCSS() {
	$plugin_root = WP_CONTENT_DIR . '/plugins';
	$oxygen_original = $plugin_root . '/oxygen/component-framework/components/';
	$nitrogen_overrides_dir = $plugin_root . '/nitrogen/overrides/';

	$file = file_get_contents($oxygen_original . "component.class.php");
	$file = str_replace("\$options['advanced'] = array();", "", $file);
	file_put_contents($oxygen_original . "component.class.php", $file);
}