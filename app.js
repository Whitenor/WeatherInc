// let test = 'test';
// console.log(test);

// document.querySelector('#shortcodeCityInput').addEventListener('change', function(e){
//     console.log(window.location.origin);
//     let toTransfert = new FormData();
//     toTransfert.append('apiKey',e.value);
//     newApiKey = new XMLHttpRequest();
//     newApiKey.open('GET',window.location.hostname+'/pluginTest/wp-content/plugins/WeatherInc/controllers/weatherIncController.php');
//     newApiKey.send();
// });
document.querySelector('#copy').addEventListener('click', function(e){
    e.preventDefault();
    console.log('good')
})