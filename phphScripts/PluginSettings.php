<?php
function save_plugin_conf_eemaster($data)
{
    $configPath = plugin_dir_path(__FILE__) . '../config.php';

    if (file_exists($configPath)) {
        $config = require $configPath;
    }

    // Make sure config is array
    if (!is_array($config)) {
        $config = [];
    }

    // Update existing config values
    foreach ($data as $key => $value) {
        $config[$key] = $value;
    }

    // Convert array back into PHP file
    $content =
        "<?php\n\nreturn " .
        var_export($config, true) .
        ";\n";

    // Save file
    file_put_contents($configPath, $content);

    return true;
}

function Generate_config_settings_page_eemaster() {

	$config = include plugin_dir_path(__FILE__) . '../config.php';
	?>
	
	<style>
		.config_rowstyleing_eeplugin {}
		.config_rowstyleing_eeplugin_rowname {}
	</style>

	<form id="eventForm">
		<h3 class="config_rowstyleing_eeplugin_rowname">Event Coordinates</h3>

		<span class="config_rowstyleing_eeplugin">
			Longitude
			<input 
				id="longitudeElement" 
				type="number" 
				step="any"  
				value="<?php echo esc_attr($config['logditude'] ?? ''); ?>" 
			/>

			Latitude
			<input 
				id="latitudeElement" 
				type="number" 
				step="any" 
				value="<?php echo esc_attr($config['latatude'] ?? ''); ?>" 
			/>
		</span>

		<button type="submit">Submit</button>
	</form>

	<script>
	document.getElementById("eventForm").addEventListener("submit", async function (e) {
		e.preventDefault();

		const longitude = document.getElementById("longitudeElement").value;
		const latitude = document.getElementById("latitudeElement").value;

		try {
			const response = await fetch("/wp-json/eeplugin/v1/eeplugin_save_config", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": "<?php echo wp_create_nonce('wp_rest'); ?>"
				},
				credentials: "same-origin",
				body: JSON.stringify({
					longitude: parseFloat(longitude),
					latitude: parseFloat(latitude)
				})
			});

			if (!response.ok) {
				throw new Error("Request failed: " + response.status);
			}

			const data = await response.json();
			console.log("Success:", data);
			alert("Saved successfully!");

		} catch (err) {
			console.error(err);
			alert("Failed to submit");
		}
	});
	</script>

	<?php
}

add_action('admin_menu', 'eemaster_add_settings_page');

function eemaster_add_settings_page()
{
    add_menu_page(
        'EE Master Settings',     // Page title
        'EE Master',              // Menu title
        'manage_options',         // Capability
        'eemaster-settings',      // Menu slug
        'Generate_config_settings_page_eemaster', // Callback
        'dashicons-admin-generic',
        80
    );
}

add_action('rest_api_init', function () {

	register_rest_route('eeplugin/v1', '/eeplugin_save_config', [
		'methods'  => 'POST',
		'callback' => 'eeplugin_save_config_settings',
		'permission_callback' => function () {
	return is_user_logged_in();
},
	]);

});

function eeplugin_save_config_settings($request) {

	$params = $request->get_json_params();

	$longitude = isset($params['longitude']) ? floatval($params['longitude']) : null;
	$latitude  = isset($params['latitude']) ? floatval($params['latitude']) : null;



	$data = [
		"logditude" => $longitude,
		"latatude" => $latitude,
	];
save_plugin_conf_eemaster($data);

	return new WP_REST_Response([
		'success' => true,
		'message' => 'Coordinates saved',
		'data'    => $data
	], 200);
}


?>
