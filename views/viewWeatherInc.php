<form class="apiKeyDiv" method="post">
    <p>Entrez votre clé api</p>
    <input type="text" name="apiKeyInput" id="apiKeyInput">
</form>
<form class="shortcode" method="post">
    <p>Entrez un nom de ville</p>
    <input type="text" name="shortcodeCityInput" id="shortcodeCityInput">
    <input type="text" name="shortcodeCityOutput" id="shortcodeCityOutput" disabled>
    <button id="copy">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M8 4v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.242a2 2 0 0 0-.602-1.43L16.083 2.57A2 2 0 0 0 14.685 2H10a2 2 0 0 0-2 2Z"/><path d="M16 18v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2"/></g></svg>
    </button>
</form>

<?php 
// function connect(){
//     require_once(ABSPATH . 'wp-config.php');
//     $sql = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASSWORD);
//     return $sql;
// }
// $query = connect()->prepare('SELECT * FROM communes where id = ?');
// $query->execute(array(1));
// $test = $query->fetchAll();
// var_dump(mb_convert_encoding($test, "UTF-8", 'ISO-8859-1'));
?>

<script src="<?= WP_PLUGIN_URL.'/WeatherInc/app.js'?>"></script>