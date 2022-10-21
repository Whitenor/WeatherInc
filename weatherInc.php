<?php 
    /* 
    Plugin Name: Weather Inc
    Plugin URI: a-piron.fr
    Description: Ce plugin a pour but d'intégrer une météo heure par heure à votre site
    Version: 1.0
    Author: Antoine Piron
    Author URI: a-piron.fr
    License: GPLv2
    */

    $dir = plugin_dir_path( __FILE__ )."controllers";
    $list = array_diff(scandir($dir), array('..','.'));
    foreach ($list as $controller) {
        require_once(plugin_dir_path( __FILE__ ).'controllers/'.$controller);
    }