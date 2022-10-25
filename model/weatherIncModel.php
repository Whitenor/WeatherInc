<?php 

class WeatherInc{
    private function connect(){
        require_once(ABSPATH . 'wp-config.php');
        $sql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
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
        global $wpdb;

        $table_name = "communes";

        $truncate = "TRUNCATE ".$table_name ;
    
        $wpdb->query($wpdb->prepare($truncate));

        $arrayCommunes = array();
        $place_holders = array(); 
        $query = "INSERT INTO $table_name (code, nom) VALUES ";
        foreach ($this->cURLCommunes() as $result) {
            foreach ($result['codesPostaux'] as $codePostal) {
                array_push( $arrayCommunes, $codePostal, $result['nom']);
                $place_holders[] = "(%s, %s)";
            }
        }
        $query .= implode(', ', $place_holders);
        $wpdb->query($wpdb->prepare("$query", $arrayCommunes));
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
        $query = $this->connect()->prepare('CREATE TABLE shortcode(ID INT(6) AUTO_INCREMENT,shortcode VARCHAR(30),PRIMARY KEY(ID)); CREATE TABLE communes(id INT(6) AUTO_INCREMENT,code INT(6),nom VARCHAR(45),PRIMARY KEY(id));');
        $query->execute();
    }
    private function cURLCommunes(){

        $curl = curl_init('https://geo.api.gouv.fr/communes');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $toTransfert = curl_exec($curl);
        mb_convert_encoding($toTransfert, 'ISO-8859-1', "UTF-8");
        curl_close($curl);
        return json_decode($toTransfert, true);
    }
    public function apiKey($target){
        global $wpdb;
        $query = $this->connect()->prepare('SELECT * FROM '.$wpdb->prefix.'options WHERE option_value = ?');
        $query->execute(array($target));
        if (count($query->fetchAll())==0) {
            $newApiKey = $this->connect()->prepare('INSERT INTO '.$wpdb->prefix.'options (option_name, option_value, autoload) VALUES(?,?,?)');
            $newApiKey->execute(array('api_key_weather_inc',$target, 'yes'));
        }
    }
    public function getExistentKey(){
        global $wpdb;
        $query = $this->connect()->prepare('SELECT * FROM '.$wpdb->prefix.'options WHERE option_value = ?');
        $query->execute(array('api_key_weather_inc'));
    }
}