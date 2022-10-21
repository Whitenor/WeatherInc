<?php 
    // require(plugin_dir_path( __FILE__ ).'../model/modelWeatherInc.php');
    $dir = plugin_dir_path( __FILE__ )."../model";
    $list = array_diff(scandir($dir), array('..','.'));
    foreach ($list as $controller) {
        require_once(plugin_dir_path( __FILE__ ).'../model/'.$controller);
    }
    function init_weather_inc(){
        $toCall = new WeatherInc;
        $toCall->init_weather_incModel();
    }
    function uninit_weather_inc(){
        $toCall = new WeatherInc;
        $toCall->uninit_weather_incModel();
    }
    function newAdminPage(){
        add_menu_page( 'WeatherInc', 'Administration de WeatherInc', 'manage_options', 'WeatherIncAdmin', 'thePage', 'dashicons-cloud' );
    }
    function thePage(){
        require(plugin_dir_path( __FILE__ )."../views/viewWeatherInc.php");
    }
    add_action('activated_plugin', 'init_weather_inc'); //lui c'est bon
    add_action('admin_menu', 'newAdminPage');
    add_action('deactivate_plugin', 'uninit_weather_inc');