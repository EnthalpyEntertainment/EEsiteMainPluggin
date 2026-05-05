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
    'https://github.com/samverheyden/google-api-php-client-main/',
    __FILE__,
    'google-api-php-client-main'
);
$updateChecker->setBranch('main');
//auto update

require_once __DIR__ . '/phphScripts/VolenteersRedirect.php';//qrcoderedirect

?>
