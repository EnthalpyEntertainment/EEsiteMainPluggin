<?php

function save_plugin_conf_eemaster($data)
{
    $configPath = plugin_dir_path(__FILE__) . '../config.php';

    // Load existing config
    $config = [];

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

function Generate_config_settings_page_eemaster(){
        	$config = require_once plugin_dir_path(__FILE__) . '../config.php';

echo '    <style>
        .config_rowstyleing_eeplugin{

        }
        .config_rowstyleing_eeplugin_rowname {
        }

    </style>';
    
echo '    <span class="config_rowstyleing_eeplugin"><span class="config_rowstyleing_eeplugin_rowname"> heading</span>longtitude<input id="logditudeelement" type="number"/>latitude <input id="latitudeelement" type="number" /></span>';
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

?>
