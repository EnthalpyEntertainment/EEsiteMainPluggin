<?php
/*
Plugin Name: EEMainSiteMasterPluggin
Description: The master EE pluggin conects and shares data with the satalight sites 
Version: 1.0.1
Author: sam verheyden
*/


$apiKey = 'gfdg44353653test';

//auto update
require_once __DIR__ . '/plugin-update-checker-master/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/EnthalpyEntertainment/EEsiteMainPluggin/',
    __FILE__,
    'EEsiteMainPluggin'
);
$updateChecker->setBranch('main');
// FORCE AUTO-UPDATES 
add_filter('auto_update_plugin', function ($update, $item) {
    $plugin_slug = plugin_basename(__FILE__);
    if ($item->plugin === $plugin_slug) {
        return true; 
    }
    return $update;
}, 10, 2);
//auto update
require_once __DIR__ . '/phphScripts/VolenteersRedirect.php';//qrcoderedirect
require_once __DIR__ . '/phphScripts/PluginSettings.php'; //settings page
?>
