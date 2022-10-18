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
    // require_once(plugin_dir_path( __FILE__ ).'weatherIncController.php');

    $dir = plugin_dir_path( __FILE__ )."controllers";
    $list = array_diff(scandir($dir), array('..','.'));
    foreach ($list as $controller) {
        require_once(plugin_dir_path( __FILE__ ).'controllers/'.$controller);
    }

    function connect(){
        require_once(ABSPATH . 'wp-config.php');
        $sql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASSWORD);
        return $sql;
    }


    function init_weather_inc(){
        $new_page = array(
            'slug' => 'blog',
            'title' => 'Blog',
            'content' => ""
        );
        wp_insert_post( array(
            'post_title' => $new_page['title'],
            'post_type'     => 'page',
            'post_name'  => $new_page['slug'],
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_content' => $new_page['content'],
            'post_status' => 'publish',
            'post_author' => 1,
            'menu_order' => 0
        ));
    };
    function test2(){
        $test = 'Blog';
        $query = connect()->prepare('SELECT ID FROM plugin_posts WHERE post_title = :toFind');
        $query->bindParam(':toFind', $test);
        $query->execute();
        // $query->execute(array('Blog'));
        $toDel = $query->fetch;
        wp_delete_post($toDel['ID']);
    }
    add_action('activated_plugin', 'init_weather_inc');
    add_action('deactivate_plugin', 'test2');