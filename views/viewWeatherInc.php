<form class="apiKeyDiv" method="post">
    <p>Entrez votre clé api</p>
    <?php 
    if ($messageApi == true) {
        echo '<p>Pensez à vous créer un compte pour récupérer une clé API <a href="https://openweathermap.org">ici</a> pour ensuite l\'ajouter ici</p>';
    }
    ?>
    <input type="text" name="apiKeyInput" id="apiKeyInput" value="<?php if ($apiKeyToTransfert !== NULL && $apiKeyToTransfert !=="") {echo $apiKeyToTransfert;}?>" style="width:300px;" maxlength="32" autocomplete="off">
    <input type="submit" value="Enregister / mettre à jour">
</form>
<form class="shortcode" method="post">
    <p>Entrez un nom de ville</p>
    <input list="communes" name="shortcodeCityInput" id="shortcodeCityInput" autocomplete="off">
    <datalist id="communes">
        <?php foreach ($communesTransfert as $commune) {
            echo '<option value="'.$commune['nom'].'">'.$commune['nom'].'</option>';
        } ?>
    </datalist>
    <input type="text" name="shortcodeCityOutput" id="shortcodeCityOutput" disabled>
    <button id="copy">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M8 4v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.242a2 2 0 0 0-.602-1.43L16.083 2.57A2 2 0 0 0 14.685 2H10a2 2 0 0 0-2 2Z"/><path d="M16 18v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2"/></g></svg>
    </button>
    <input type="submit" value="Enregistrer la ville souhaitée" id="test">
</form>

<?php 
$test3 = "Laons";
$test4 = "bacd25324b846f4ee9568417943e5932";
$test = curl_init("https://api.openweathermap.org/data/2.5/weather?q=$test3&appid=$test4&units=metric");
curl_setopt($test, CURLOPT_RETURNTRANSFER, true);
curl_setopt($test, CURLOPT_SSL_VERIFYPEER, false);
$test2 = json_decode(curl_exec($test),true);
curl_close($test);

$testForecast5 = curl_init("https://api.openweathermap.org/data/2.5/forecast?q=$test3&appid=$test4&units=metric");
curl_setopt($testForecast5, CURLOPT_RETURNTRANSFER, true);
curl_setopt($testForecast5, CURLOPT_SSL_VERIFYPEER, false);
$forecast5 = json_decode(curl_exec($testForecast5),true);
curl_close($testForecast5);
echo "<pre>";
var_dump($forecast5['list'][0]);
echo "</pre>";
?>
<script src="<?= WP_PLUGIN_URL.'/WeatherInc/app.js'?>"></script>