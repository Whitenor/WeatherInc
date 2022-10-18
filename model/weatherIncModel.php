<?php 

class WeatherInc{
    function connect(){
        require_once(ABSPATH . 'wp-config.php');
        $sql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASSWORD);
        return $sql;
    }


    public function init_weather_incModel(){
        if ($this->checkExistant() == false) {
            $new_page = array(
                'slug' => 'wheaterinc',
                'title' => 'WheatherInc',
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
        }
        $query = $this->connect()->prepare('CREATE TABLE shortcode(ID INT(6),shortcode VARCHAR(30),PRIMARY KEY(ID)); CREATE TABLE communes(id INT(6),code INT(6),nom VARCHAR(30),PRIMARY KEY(id));');
        $query->execute();
    }

    private function checkExistant(){
        $query = $this->connect()->prepare('SELECT * FROM plugin_posts WHERE post_title = WeatherInc');
        $query->execute();
        $toCheck = $query->fetchAll();
        $check = count($toCheck);
        if ($check > 0) {
            return true;
        }
        else{
            return false;
        }
    }

    public function uninit_weather_incModel(){
        $query = $this->connect()->prepare('SELECT ID FROM plugin_posts WHERE post_title = ?');
        $query->execute(array('WheatherInc'));
        $toDel = $query->fetchAll();
        for ($i=0; $i < count($toDel); $i++) { 
            wp_delete_post($toDel[$i]['ID'] , true);
        };

        $query = $this->connect()->prepare('DROP TABLE communes, shortcode; ');
        $query->execute();
    }
}