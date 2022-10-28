
<?php ob_start();?>
<style>
    .card{
        width: 300px;
        background-color: #DDDDDD;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .summaryWeather{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .forecast5day{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }
    .pluginWeatherInc{
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
<div class="pluginWeatherInc">

        <details class="card WeatherNow">
            <summary class="summaryWeather">
                <img src="http://openweathermap.org/img/wn/<?= $resultNow['weather'][0]['icon']?>.png" alt="">
                <h3><?= $city['city']?></h3>
                <p>Cliquez pour plus d'infos</p>
            </summary>
            <div class="moreInfo">
                <p><?= $resultNow['main']['temp']?>°C actuellement</p>
                <p><?= $resultNow['main']['feels_like']?>°C ressenti</p>
                <p>Vitesse du vent: <?= $resultNow['wind']['speed']?>km/h</p>
            </div>
        </details>

    <div class="forecast5day">
        <details class="card">
            <summary class="summaryWeather">
                <img src="http://openweathermap.org/img/wn/<?= $forecast5['list'][0]['weather'][0]['icon']?>.png" alt="">
                <h3><?= $forecast5['city']['name']?></h3>
                <p>Cliquez pour plus d'infos</p>
            </summary>
            <div class="moreInfo">test détail 1</div>
        </details>
    </div>
</div>

<?php 

echo '<pre>';
// var_dump($key);
// var_dump($city);
var_dump($key[0]['option_value']);
var_dump($result5Day);
echo '</pre>';
$viewPluginWeatherInc = ob_get_clean();