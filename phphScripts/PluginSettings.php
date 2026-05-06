<?php
function save_plugin_conf_eemaster($data){
$configPath = plugin_dir_path(__FILE__) . 'config.php';
$content = "<?php\nreturn " . var_export($data, true) . ";\n";
file_put_contents($configPath, $content);
}


?>
