// let test = 'test';
// console.log(test);

document.querySelector('#shortcodeCityInput').addEventListener('change', function(e){
    console.log('good');
    let toTransfert = new FormData();
    toTransfert.append('apiKey',e.value);
    newApiKey = new XMLHttpRequest();
    newApiKey.open('POST','./controllers/weatherIncController.php');
    newApiKey.abort();
});
