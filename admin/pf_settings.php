<?php
function pf_settings_callback() { ?>
    <h2>Profectus Settings</h2>
    <p><strong>Dev Mode</strong></p>
    <select id="dev_mode">
        <option>Disabled</option>
        <option>Enabled</option>
    </select>
    <label for="dev_mode">Enable Oxygen Developer Mode</label>
    <p><strong>Import CSS Global</strong></p>
    <input id="global_css">
    <label for="global_css">Add</label>
<?php
submit_button( 'Apply' );
}
