<?php 

class WeatherInc{
    private function connect(){
        require_once(ABSPATH . 'wp-config.php');
        $sql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASSWORD);
        return $sql;
    }


    public function init_weather_incModel(){
        if ($this->checkPageExistant() == false) {
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
        $this->createTable();
        $results = json_decode($this->cURLCommunes(), true);
        foreach ($results as $result) {
            $query = $this->connect()->prepare('INSERT INTO communes (code, nom) VALUES (?,?)');
            $query->execute(array($result['codesPostaux'][0], $result['nom']));
        }
    }
    public function uninit_weather_incModel(){
        global $wpdb;
        $query = $this->connect()->prepare('SELECT ID FROM '.$wpdb->prefix.'posts WHERE post_title = ?');
        $query->execute(array('WheatherInc'));
        $toDel = $query->fetchAll();
        for ($i=0; $i < count($toDel); $i++) { 
            wp_delete_post($toDel[$i]['ID'] , true);
        };

        $query = $this->connect()->prepare('DROP TABLE communes, shortcode; ');
        $query->execute();
    }

    private function checkPageExistant(){
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
    
    private function createTable(){
        $query = $this->connect()->prepare('CREATE TABLE shortcode(ID INT(6) AUTO_INCREMENT,shortcode VARCHAR(30),PRIMARY KEY(ID)); CREATE TABLE communes(id INT(6) AUTO_INCREMENT,code INT(6),nom VARCHAR(30),PRIMARY KEY(id));');
        $query->execute();
    }
    private function cURLCommunes(){
        $curl = curl_init();
        $url = 'https://geo.api.gouv.fr/communes';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        return curl_exec($curl);
        curl_close($curl);
    }
    public function apiKey($target){
        require_once(ABSPATH . 'wp-config.php');
        $query = $this->connect()->prepare('SELECT * FROM '.$table_prefix.'options WHERE option_value = ?');
        $query->execute(array($target));
        if (count($query->fetchAll())==0) {
            $newApiKey = $this->connect()->prepare('INSERT INTO '.$table_prefix.' (option_name, option_value, autoload) VALUES(?,?,?)');
            $newApiKey->execute(array('api_key_weather_inc',$target, 'yes'));
        }
    }
    public function getExistentKey(){
        
    }
}