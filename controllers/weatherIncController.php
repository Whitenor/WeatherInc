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
        $checkKey = new WeatherInc;
        $resultCheck = $checkKey->getExistentKey();
        if (count($resultCheck) > 0 ) {
            $apiKeyToTransfert = $resultCheck[0]['option_value'];
        }elseif (isset($_POST['apiKeyInput']) && !empty($_POST['apiKeyInput']) && $_POST['apiKeyInput'] == $_POST['apiKeyInput']){
            $insertKey = new WeatherInc;
            $apiKeyToTransfert = $insertKey->setApiKey($_POST['apiKeyInput']);
        }elseif(isset($_POST['apiKeyInput']) && !empty($_POST['apiKeyInput']) && $_POST['apiKeyInput'] != $_POST['apiKeyInput']){
            $updateKey = new WeatherInc;
            $apiKeyToTransfert = $updateKey->setNewApiKey($_POST['apiKeyInput']);
        }else{
            $messageApi = true;
        }
        if (isset($_POST['shortcodeCityInput']) && !empty($_POST['shortcodeCityInput'])) {
            $newShortcode = new WeatherInc;
            $shortcodeToTransfert = $newShortcode->setShortcode($_POST['shortcodeCityInput']);
        }
        $communes = new WeatherInc;
        $communesTransfert = json_decode(json_encode($communes->getCommunes()),true);
        require(plugin_dir_path( __FILE__ )."../views/viewWeatherInc.php");
        // require(plugin_dir_path( __FILE__ )."../views/viewPluginWeatherInc.php");
    }
    function shortcodeWeatherInc($atts){
        $getWeather = new WeatherInc;
        $key = $getWeather->getExistentKey();
        
        return $atts['ville'];
    }
    add_action('activated_plugin', 'init_weather_inc');
    add_action('admin_menu', 'newAdminPage');
    add_action('deactivate_plugin', 'uninit_weather_inc');
    
    
    // add_shortcode('meteo', 'shortcodeWeatherInc');