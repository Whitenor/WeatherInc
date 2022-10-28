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
        $weatherInc = new WeatherInc;
        $resultCheck = $weatherInc->getExistentKey();
        if (isset($_POST['apiKeyInput']) && !empty($_POST['apiKeyInput']) && $_POST['apiKeyInput'] == $resultCheck[0]['option_value']){
            $apiKeyToTransfert = $weatherInc->setApiKey($_POST['apiKeyInput']);
        }elseif(isset($_POST['apiKeyInput']) && !empty($_POST['apiKeyInput']) && $_POST['apiKeyInput'] != $resultCheck[0]['option_value']){
            $apiKeyToTransfert = $weatherInc->setNewApiKey($_POST['apiKeyInput']);
        }else{
            $messageApi = true;
        }
        if (isset($_POST['shortcodeCityInput']) && !empty($_POST['shortcodeCityInput'])) {
            $shortcodeToTransfert = $weatherInc->setShortcode($_POST['shortcodeCityInput']);
            $shortcodeToTransfert = $_POST['shortcodeCityInput'];
        }
        $listShortcode = json_decode(json_encode($weatherInc->getShortcode()),true);
        $shortcodeToTransfert = $listShortcode[0]['shortcode'];
        $communesTransfert = json_decode(json_encode($weatherInc->getCommunes()),true);
        require(plugin_dir_path( __FILE__ )."../views/viewWeatherInc.php");
        // require(plugin_dir_path( __FILE__ )."../views/viewPluginWeatherInc.php");
    }
    function shortcodeWeatherInc($atts){
        $getWeather = new WeatherInc;
        $key = $getWeather->getExistentKey();
        $city = $atts;
        $resultNow = $getWeather->getWeather($city['city'], $key[0]['option_value']);
        $result5Day= $getWeather->getWeather5Day($city['city'], $key[0]['option_value']);
        require_once(plugin_dir_path( __FILE__ )."../views/viewPluginWeatherInc.php");
        return $viewPluginWeatherInc;
    }
    add_action('activated_plugin', 'init_weather_inc');
    add_action('admin_menu', 'newAdminPage');
    add_action('deactivate_plugin', 'uninit_weather_inc');
    
    
    add_shortcode('meteo', 'shortcodeWeatherInc');  