// let test = 'test';
// console.log(test);

document.querySelector('#apiKeyInput').addEventListener('change', function(e){
    let toTransfert = new FormData();
    toTransfert.append('apiKey',e.value);
    newApiKey = new XMLHttpRequest();
    newApiKey.open('POST','./controllers/weatherIncController.php');
    newApiKey.abort();
});
