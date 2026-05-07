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
        $config = require plugin_dir_path(__FILE__) . '../config.php';
}
    

?>
