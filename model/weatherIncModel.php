<?php 

class WeatherInc{
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
        $toDel = json_decode(json_encode($wpdb->get_results($wpdb->prepare("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_title = %s", array('WheatherInc')))),true);
        for ($i=0; $i < count($toDel); $i++) { 
            wp_delete_post($toDel[$i]['ID'] , true);
        };

        $wpdb->query($wpdb->prepare('DROP TABLE communes, shortcode; '));
    }
    private function checkPageExistant(){
        global $wpdb;
        $toCheck = json_decode(json_encode($wpdb->get_results($wpdb->prepare("SELECT * FROM plugin_posts WHERE post_title = %s", array('WeatherInc')))),true);
        $check = count($toCheck);
        if ($check > 0) {
            return true;
        }
        else{
            return false;
        }
    }
    private function createTable(){
        global $wpdb;
        $wpdb->query($wpdb->prepare("CREATE TABLE shortcode(ID INT(6) AUTO_INCREMENT,shortcode VARCHAR(45),PRIMARY KEY(ID))"));
        $wpdb->query($wpdb->prepare("CREATE TABLE communes(id INT(6) AUTO_INCREMENT,code INT(6),nom VARCHAR(45),PRIMARY KEY(id));"));
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
    public function setApiKey($target){
        global $wpdb;
        $arrayForInsert= array("apiKey", $target, "yes") ;
        $wpdb->get_results($wpdb->prepare("INSERT INTO ".$wpdb->prefix."options (option_name, option_value,autoload) VALUES (%s, %s, %s)", $arrayForInsert));
        return $target;
    }
    public function getExistentKey(){
        global $wpdb;
        $toCheck = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."options WHERE option_name = %s", "apiKey"));
        return json_decode(json_encode($toCheck), true);
    }
    public function getCommunes(){
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare("SELECT nom FROM communes;"));
    }
}